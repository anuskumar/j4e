<?php

namespace App\Http\Controllers;

use App\Models\OrderStatusUpdate;
use App\Models\TicketPurchase;
use App\Models\TicketsGenerated;

use App\Models\Events;
use App\Models\EventTickets;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session as FacadesSession;
use App\Http\Controllers\Emailj4eController;
use Session;
// use Stripe;
use Stripe\Stripe;
use Stripe\Charge;
use Stripe\Stripe as StripeStripe;
use Stripe\StripeClient;

class StripePaymentController extends Controller
{
     /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe()
    {
        // return view('stripe.stripe');
        return redirect()->route('home');
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request)
    {



        info($request->all());
        // dd($request->all());
        // Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $stripe = new StripeClient(env('STRIPE_SECRET'));

        try {
            // Make the Stripe API request here
        } catch (\Stripe\Exception\CardException $e) {
            // Card was declined
            $error = $e->getError();
            return back()->withErrors(['cardError' => $error['message']]);
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            // Invalid parameters were supplied to Stripe's API
            // Handle this accordingly
            $error = $e->getError();
            return back()->withErrors(['cardError' => $error['message']]);
        } catch (\Stripe\Exception\AuthenticationException $e) {
            // Authentication with Stripe's API failed
            // Handle this accordingly
            $error = $e->getError();
            return back()->withErrors(['cardError' => $error['message']]);
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            // Network communication with Stripe failed
            // Handle this accordingly
            $error = $e->getError();
            return back()->withErrors(['cardError' => $error['message']]);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            // Generic error handling
            // Handle this accordingly
            $error = $e->getError();
            return back()->withErrors(['cardError' => $error['message']]);
        }

        // dd($request->stripeToken);

        // $data =  $stripe->paymentIntents->create([
        //     'amount' => $request->payment_amount == 0  ? 1 : $request->payment_amount * 100,
        //     'currency' => $request->currency_name,
        //     'automatic_payment_methods' => ['enabled' => true],
        //   ]);

        // Normalise amount and enforce Stripe minimums per currency
        $currency = strtolower($request->currency_name);
        $amount   = (float) $request->payment_amount;

        // Convert to smallest currency unit (e.g. cents, fils)
        $amountInSmallestUnit = (int) round($amount * 100);

        // Stripe minimum amounts (in smallest unit). Adjusted for AED (200 fils = 2.00 AED).
        $minByCurrency = [
            'aed' => 200,
            'usd' => 50,
            'eur' => 50,
            // fallback for most other currencies
        ];

        $minForCurrency = $minByCurrency[$currency] ?? 50;

        if ($amountInSmallestUnit < $minForCurrency) {
            $minDisplay = number_format($minForCurrency / 100, 2);

            return back()->withErrors([
                'cardError' => "Minimum charge amount is {$minDisplay} " . strtoupper($currency) . ". Please increase the ticket quantity or price.",
            ]);
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $data = Charge::create([
            'amount'   => $amountInSmallestUnit,
            'currency' =>  $currency,
            'source'   => $request->stripeToken,
        ]);

        //   dd($data);

        if(env('STRIPE_STATUS')=='testing' | $data->amount_received==1){
            $ticket = new TicketPurchase();
            $ticket->event_id = $request->event_id;
            $ticket->event_ticket_id = $request->event_ticket_id;
            $ticket->total_number = $request->total_number;
            $ticket->shipping_name = $request->shipping_name;
            $ticket->shipping_address1 = $request->shipping_address1;
            $ticket->shipping_address2 = $request->shipping_address2;
            $ticket->shipping_country = $request->shipping_country;
            $ticket->shipping_city = $request->shipping_city;
            $ticket->shipping_pincode = $request->shipping_pincode;
            $ticket->accepted_tearms_condetion = $request->accepted_tearms_condetion ? true :false;
            $ticket->payment_amount = $request->payment_amount;
            $ticket->payment_currency = $request->currency_name;
            $ticket->payment_card_number = $data->source->last4;
            $ticket->purchase_status = 1;
            $ticket->payment_date = date('Y-m-d H:i:s');
            $ticket->is_payment_completed = $data->amount_received ? 1: 0;
            $ticket->payment_id = $data->id;
            $ticket->user_id =Auth::user()->id;

            $ticket->save();


            $ticket_count = TicketsGenerated::where('event_tickets', $request->event_ticket_id)
            ->where('user_id',Auth::user()->id)->where('is_sold',0)->where('under_purchase_hold',1)->get();

            $ticket_count_data=TicketsGenerated::where('event_tickets', $request->event_ticket_id)
            ->where('user_id',Auth::user()->id)->where('is_sold',0)->where('under_purchase_hold',1)->count();

            foreach($ticket_count as $count){

                $generated = TicketsGenerated::find($count->id);
                $generated->purchase_id = $ticket->id;
                $generated->is_sold = 1;
                $generated->under_purchase_hold = 0;
                $generated->purchase_hold_time = null;
                $generated->purchase_date = date('Y-m-d H:i:s');
                $generated->save();

            }

            $data = new OrderStatusUpdate();
            $data->purchase_id = $ticket->id;
            $data->status_id = 1;
            $data->created_by = Auth::user()->id;
            $data->save();


            $order_id = $data->id;

            $event = Events::where('id',$request->event_id)->first();
            $event_tickets = EventTickets::where('id',$request->event_ticket_id)->first();
            $user_data = User::where('id',$event_tickets->created_by)->first();



            $maildata = [
                'email' => $user_data->email,
                'resellername' => $user_data->name,
                'eventname' => $event->event_name,
                'eventdate' => $event->event_from_date,
                'ticket_name' => $event_tickets->ticket_name,
                'ticket_count_data' => $ticket_count_data,
                'price' => $event_tickets->ticket_amount
            ];

    // $userEmail = 'sheebarobert18@gmail.com';

    // $emailController = new Emailj4eController();
    // $emailController->ticketsoldmail($maildata);


    //         FacadesSession::flash('success', 'Payment successful!');

            return view('stripe.booking_success_modal',['order_id' => $order_id]);

            //  return redirect('booking_success'.'/'.$ticket->id);

        }else{

            // return redirect('booking_failed');
            return view('stripe.booking_failed_modal');
        }


    }
}
