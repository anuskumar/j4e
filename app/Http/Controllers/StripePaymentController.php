<?php

namespace App\Http\Controllers;

use App\Models\TicketPurchase;
use App\Services\TicketCheckoutService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Charge;
use Stripe\Stripe;

class StripePaymentController extends Controller
{
    public function __construct(private TicketCheckoutService $checkoutService)
    {
    }

    public function stripe()
    {
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

    public function stripePost(Request $request)
    {
        $validated = $request->validate(array_merge(
            $this->checkoutService->shippingRules(),
            ['stripeToken' => 'required|string']
        ), $this->checkoutService->shippingMessages());

        $checkout = $this->checkoutService->prepareCheckout($request, 'cardError');
        if (isset($checkout['errors'])) {
            return back()->withErrors($checkout['errors'])->withInput();
        }

        $currency = $checkout['currency'];
        $expectedAmount = $checkout['expected_amount'];
        $requestedCount = $checkout['requested_count'];
        $amountInSmallestUnit = (int) round($expectedAmount * 100);

        $minByCurrency = [
            'aed' => 200,
            'usd' => 50,
            'eur' => 50,
        ];

        $minForCurrency = $minByCurrency[$currency] ?? 50;

        if ($amountInSmallestUnit < $minForCurrency) {
            $minDisplay = number_format($minForCurrency / 100, 2);
            $currentAmount = number_format($expectedAmount, 2);

            return back()->withErrors([
                'cardError' => "Payment amount ({$currentAmount} " . strtoupper($currency) . ") is below the minimum charge amount of {$minDisplay} " . strtoupper($currency) . ". Please check the ticket price.",
            ])->withInput();
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $data = Charge::create([
                'amount' => $amountInSmallestUnit,
                'currency' => $currency,
                'source' => $request->stripeToken,
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

        if (! $paymentSucceeded) {
            return view('stripe.booking_failed_modal');
        }

        $existingPurchase = TicketPurchase::where('payment_id', $data->id)->first();
        if ($existingPurchase) {
            return redirect()->route('customer.booking.confirmed', $existingPurchase->id);
        }

        try {
            $ticket = $this->checkoutService->fulfillPurchase(
                $checkout,
                $request,
                $data->id,
                $this->resolveChargeLast4($data)
            );
        } catch (\Exception $e) {
            report($e);

            return back()->withErrors([
                'cardError' => 'Payment was captured but order confirmation failed. Please contact support with payment reference: ' . ($data->id ?? 'N/A'),
            ]);
        }

        return redirect()->route('customer.booking.confirmed', $ticket->id);
    }

    private function resolveChargeLast4($charge): ?string
    {
        if (isset($charge->payment_method_details->card->last4)) {
            return $charge->payment_method_details->card->last4;
        }

        if (isset($charge->source) && is_object($charge->source) && isset($charge->source->last4)) {
            return $charge->source->last4;
        }

        return null;
    }
}
