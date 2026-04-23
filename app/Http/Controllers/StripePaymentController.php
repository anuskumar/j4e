<?php

namespace App\Http\Controllers;

use App\Models\OrderStatusUpdate;
use App\Models\TicketPurchase;
use App\Models\TicketsGenerated;

use App\Models\Events;
use App\Models\EventTickets;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session as FacadesSession;
use App\Http\Controllers\Emailj4eController;
use Session;
// use Stripe;
use Stripe\Stripe;
use Stripe\Charge;

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
        if (Auth::check()) {
            $userType = Auth::user()->user_type;
            if ($userType === 'superadmin') {
                return redirect()->route('admin.home');
            } elseif ($userType === 'customer') {
                return redirect()->route('customer.home');
            } elseif ($userType === 'reseller') {
                return redirect()->route('reseller.home');
            }
        }
        return redirect()->route('home');
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request)
    {
        // Validate shipping address fields
        $validated = $request->validate([
            'shipping_name' => 'required|string|max:255',
            'shipping_address1' => 'required|string|max:500',
            'shipping_address2' => 'nullable|string|max:500',
            'shipping_country' => 'required|numeric|exists:countries,id',
            'shipping_city' => 'required|string|max:255',
            'shipping_pincode' => 'required|string|max:20',
            'stripeToken' => 'required|string',
            'payment_amount' => 'required|numeric|min:0',
            'event_id' => 'required|numeric|exists:event,id',
            'event_ticket_id' => 'required|numeric|exists:event_tickets,id',
            'total_number' => 'required|numeric|min:1',
            'currency_name' => 'required|string',
        ], [
            'shipping_name.required' => 'Please enter your name.',
            'shipping_address1.required' => 'Please enter your address.',
            'shipping_country.required' => 'Please select a country.',
            'shipping_country.exists' => 'Please select a valid country.',
            'shipping_city.required' => 'Please enter your city.',
            'shipping_pincode.required' => 'Please enter your pincode.',
        ]);

        // Normalise amount and enforce Stripe minimums per currency
        $currency = strtolower($request->currency_name);
        $requestedCount = (int) $request->total_number;
        $amount = (float) $request->payment_amount;
        
        // Check if amount is 0 or very small first
        if ($amount <= 0) {
            return back()->withErrors([
                'cardError' => "Invalid payment amount. Please check the ticket price and quantity.",
            ])->withInput();
        }

        $eventTicket = EventTickets::find($request->event_ticket_id);
        if (! $eventTicket) {
            return back()->withErrors([
                'cardError' => 'Selected ticket is not available.',
            ])->withInput();
        }

        // Prevent event_id tampering from client payload.
        if ((int) $eventTicket->event !== (int) $request->event_id) {
            return back()->withErrors([
                'cardError' => 'Invalid event selection for this ticket.',
            ])->withInput();
        }

        // Validate selected quantity against currently held tickets for this user.
        $holdValidFrom = now()->subMinutes(15);
        $heldTicketsQuery = TicketsGenerated::where('event_tickets', $request->event_ticket_id)
            ->where('user_id', Auth::user()->id)
            ->where('is_sold', 0)
            ->where('under_purchase_hold', 1)
            ->where('purchase_hold_time', '>=', $holdValidFrom)
            ->orderBy('id');

        $heldCount = (int) $heldTicketsQuery->count();

        if ($heldCount < 1) {
            return back()->withErrors([
                'cardError' => 'Your ticket hold has expired. Please select tickets again.',
            ])->withInput();
        }

        if ($requestedCount > $heldCount) {
            $additionalNeeded = $requestedCount - $heldCount;

            $additionalTickets = TicketsGenerated::where('event_tickets', $request->event_ticket_id)
                ->where('is_sold', 0)
                ->where('under_purchase_hold', 0)
                ->orderBy('id')
                ->take($additionalNeeded)
                ->lockForUpdate()
                ->get();

            if ($additionalTickets->count() < $additionalNeeded) {
                $maxAvailableNow = $heldCount + $additionalTickets->count();
                return back()->withErrors([
                    'cardError' => "Only {$maxAvailableNow} ticket(s) are available right now.",
                ])->withInput();
            }

            foreach ($additionalTickets as $additionalTicket) {
                $additionalTicket->user_id = Auth::id();
                $additionalTicket->under_purchase_hold = 1;
                $additionalTicket->purchase_hold_time = now();
                $additionalTicket->save();
            }

            $heldTicketsQuery = TicketsGenerated::where('event_tickets', $request->event_ticket_id)
                ->where('user_id', Auth::user()->id)
                ->where('is_sold', 0)
                ->where('under_purchase_hold', 1)
                ->where('purchase_hold_time', '>=', $holdValidFrom)
                ->orderBy('id');

            $heldCount = (int) $heldTicketsQuery->count();
            if ($requestedCount > $heldCount) {
                return back()->withErrors([
                    'cardError' => "Unable to reserve requested quantity. Please try again.",
                ])->withInput();
            }
        }

        $unitPrice = (float) ($eventTicket->ticket_amount ?? 0);
        $expectedAmount = round($unitPrice * $requestedCount, 2);

        // Use server-side amount calculation to avoid client-side tampering/mismatch.
        $amount = $expectedAmount;

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
            $currentAmount = number_format($amount, 2);

            return back()->withErrors([
                'cardError' => "Payment amount ({$currentAmount} " . strtoupper($currency) . ") is below the minimum charge amount of {$minDisplay} " . strtoupper($currency) . ". Please check the ticket price.",
            ])->withInput();
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $data = Charge::create([
                'amount'   => $amountInSmallestUnit,
                'currency' =>  $currency,
                'source'   => $request->stripeToken,
                'metadata' => [
                    'event_ticket_id' => (string) $request->event_ticket_id,
                    'event_id' => (string) $request->event_id,
                    'user_id' => (string) Auth::id(),
                    'total_number' => (string) $requestedCount,
                ],
            ]);
        } catch (\Stripe\Exception\CardException $e) {
            return back()->withErrors(['cardError' => $e->getError()['message'] ?? 'Card was declined.'])->withInput();
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            return back()->withErrors(['cardError' => $e->getError()['message'] ?? 'Invalid payment request.'])->withInput();
        } catch (\Stripe\Exception\AuthenticationException $e) {
            return back()->withErrors(['cardError' => $e->getError()['message'] ?? 'Payment gateway authentication failed.'])->withInput();
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            return back()->withErrors(['cardError' => $e->getError()['message'] ?? 'Network error while contacting payment gateway.'])->withInput();
        } catch (\Stripe\Exception\ApiErrorException $e) {
            return back()->withErrors(['cardError' => $e->getError()['message'] ?? 'Payment gateway error.'])->withInput();
        } catch (\Exception $e) {
            return back()->withErrors(['cardError' => 'Unable to process payment at the moment. Please try again.'])->withInput();
        }

        $paymentSucceeded = (($data->status ?? null) === 'succeeded')
            || (($data->paid ?? false) && (int) ($data->amount_received ?? 0) >= $amountInSmallestUnit);
        if ($paymentSucceeded) {
            DB::beginTransaction();
            try {
            $ticket = new TicketPurchase();
            $ticket->event_id = $request->event_id;
            $ticket->event_ticket_id = $request->event_ticket_id;
            $ticket->total_number = $requestedCount;
            $ticket->shipping_name = $request->shipping_name;
            $ticket->shipping_address1 = $request->shipping_address1;
            $ticket->shipping_address2 = $request->shipping_address2;
            $ticket->shipping_country = $request->shipping_country;
            $ticket->shipping_city = $request->shipping_city;
            $ticket->shipping_pincode = $request->shipping_pincode;
            $ticket->accepted_tearms_condetion = $request->accepted_tearms_condetion ? true :false;
            $ticket->payment_amount = $expectedAmount;
            $ticket->payment_currency = strtoupper($currency);
            $ticket->payment_card_number = $data->source->last4;
            $ticket->purchase_status = 1;
            $ticket->payment_date = date('Y-m-d H:i:s');
            $ticket->is_payment_completed = $paymentSucceeded ? 1 : 0;
            $ticket->payment_id = $data->id;
            $ticket->user_id =Auth::user()->id;

            $ticket->save();


            $ticket_count = $heldTicketsQuery->take($requestedCount)->get();
            $remainingHeldTickets = TicketsGenerated::where('event_tickets', $request->event_ticket_id)
                ->where('user_id', Auth::user()->id)
                ->where('is_sold', 0)
                ->where('under_purchase_hold', 1)
                ->where('purchase_hold_time', '>=', $holdValidFrom)
                ->whereNotIn('id', $ticket_count->pluck('id'))
                ->get();

            $ticket_count_data = $ticket_count->count();

            foreach($ticket_count as $count){

                $generated = TicketsGenerated::find($count->id);
                $generated->purchase_id = $ticket->id;
                $generated->is_sold = 1;
                $generated->under_purchase_hold = 0;
                $generated->purchase_hold_time = null;
                $generated->purchase_date = date('Y-m-d H:i:s');
                $generated->save();

            }

            // Release any extra held tickets that were not part of this purchase.
            foreach ($remainingHeldTickets as $remainingTicket) {
                $generated = TicketsGenerated::find($remainingTicket->id);
                $generated->user_id = null;
                $generated->under_purchase_hold = 0;
                $generated->purchase_hold_time = null;
                $generated->save();
            }

            $orderStatus = new OrderStatusUpdate();
            $orderStatus->purchase_id = $ticket->id;
            $orderStatus->status_id = 1;
            $orderStatus->created_by = Auth::user()->id;
            $orderStatus->save();

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

            $customerUser = Auth::user();
            $currencyCode = strtoupper($currency);
            $totalPaid = number_format((float) $expectedAmount, 2);
            $eventName = (string) ($event->event_name ?? '');
            $eventDate = (string) ($event->event_from_date ?? '');
            $ticketName = (string) ($event_tickets->ticket_name ?? '');
            $purchaseId = (int) ($ticket->id ?? 0);
            $soldCount = (int) $ticket_count_data;

            if ($customerUser && !empty($customerUser->email)) {
                try {
                    $customerHtml = '
                        <h2>Ticket Purchase Confirmation</h2>
                        <p>Hi ' . e($customerUser->name ?? 'Customer') . ',</p>
                        <p>Your payment was successful.</p>
                        <ul>
                            <li><strong>Purchase ID:</strong> #' . $purchaseId . '</li>
                            <li><strong>Event:</strong> ' . e($eventName) . '</li>
                            <li><strong>Event Date:</strong> ' . e($eventDate) . '</li>
                            <li><strong>Ticket:</strong> ' . e($ticketName) . '</li>
                            <li><strong>Ticket Count:</strong> ' . $soldCount . '</li>
                            <li><strong>Total Amount:</strong> ' . $totalPaid . ' ' . e($currencyCode) . '</li>
                        </ul>
                    ';

                    Mail::html($customerHtml, function ($message) use ($customerUser, $purchaseId) {
                        $message->to($customerUser->email)
                            ->subject('Your Ticket Purchase Confirmation #' . $purchaseId);
                    });
                } catch (\Exception $customerMailException) {
                    report($customerMailException);
                }
            }

            if ($user_data && !empty($user_data->email)) {
                try {
                    $resellerHtml = '
                        <h2>Ticket Sold Notification</h2>
                        <p>Hi ' . e($user_data->name ?? 'Reseller') . ',</p>
                        <p>A customer has completed ticket purchase.</p>
                        <ul>
                            <li><strong>Purchase ID:</strong> #' . $purchaseId . '</li>
                            <li><strong>Customer:</strong> ' . e($customerUser->name ?? 'Customer') . '</li>
                            <li><strong>Event:</strong> ' . e($eventName) . '</li>
                            <li><strong>Event Date:</strong> ' . e($eventDate) . '</li>
                            <li><strong>Ticket:</strong> ' . e($ticketName) . '</li>
                            <li><strong>Ticket Count:</strong> ' . $soldCount . '</li>
                            <li><strong>Total Amount:</strong> ' . $totalPaid . ' ' . e($currencyCode) . '</li>
                        </ul>
                    ';

                    Mail::html($resellerHtml, function ($message) use ($user_data, $purchaseId) {
                        $message->to($user_data->email)
                            ->subject('Ticket Sold Notification #' . $purchaseId);
                    });
                } catch (\Exception $resellerMailException) {
                    report($resellerMailException);
                }
            }

            DB::commit();

            // Redirect to customer home/profile page (shows their orders/bookings)
            return redirect()->route('customer.home')->with('success', 'Payment successful! Your order has been confirmed.');
            } catch (\Exception $e) {
                DB::rollBack();
                report($e);
                return back()->withErrors([
                    'cardError' => 'Payment was captured but order confirmation failed. Please contact support with payment reference: ' . ($data->id ?? 'N/A'),
                ]);
            }

        }else{

            // return redirect('booking_failed');
            return view('stripe.booking_failed_modal');
        }


    }
}
