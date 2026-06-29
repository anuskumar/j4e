<?php

namespace App\Http\Controllers;

use App\Models\TicketPurchase;
use App\Services\PaypalService;
use App\Services\TicketCheckoutService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaypalPaymentController extends Controller
{
    public function __construct(
        private TicketCheckoutService $checkoutService,
        private PaypalService $paypalService
    ) {
        $this->middleware('auth');
    }

    public function createOrder(Request $request)
    {
        if (! $this->paypalService->isReady()) {
            return response()->json(['error' => 'PayPal payments are not available right now.'], 422);
        }

        $validated = $request->validate(array_merge(
            $this->checkoutService->shippingRules(),
            []
        ), $this->checkoutService->shippingMessages());

        $checkout = $this->checkoutService->prepareCheckout($request, 'paypalError');
        if (isset($checkout['errors'])) {
            return response()->json([
                'error' => collect($checkout['errors'])->first(),
            ], 422);
        }

        try {
            $orderId = $this->paypalService->createOrder(
                $checkout['expected_amount'],
                $checkout['currency'],
                [
                    'event_ticket_id' => $checkout['event_ticket_id'],
                    'event_id' => $checkout['event_id'],
                    'user_id' => Auth::id(),
                    'total_number' => $checkout['requested_count'],
                ]
            );
        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'error' => $e->getMessage(),
            ], 422);
        }

        return response()->json(['id' => $orderId]);
    }

    public function captureOrder(Request $request)
    {
        if (! $this->paypalService->isReady()) {
            return response()->json(['error' => 'PayPal payments are not available right now.'], 422);
        }

        $request->validate(array_merge(
            $this->checkoutService->shippingRules(),
            ['order_id' => 'required|string|max:255']
        ), $this->checkoutService->shippingMessages());

        $checkout = $this->checkoutService->prepareCheckout($request, 'paypalError');
        if (isset($checkout['errors'])) {
            return response()->json([
                'error' => collect($checkout['errors'])->first(),
            ], 422);
        }

        try {
            $captureResponse = $this->paypalService->captureOrder($request->order_id);
            $capture = $this->paypalService->extractCaptureDetails($captureResponse);
        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'error' => $e->getMessage(),
            ], 422);
        }

        if (($capture['order_status'] ?? null) !== 'COMPLETED' || ($capture['capture_status'] ?? null) !== 'COMPLETED') {
            return response()->json([
                'error' => 'PayPal payment was not completed. Please try again.',
            ], 422);
        }

        if ($capture['amount'] === null || abs($capture['amount'] - $checkout['expected_amount']) > 0.01) {
            return response()->json([
                'error' => 'PayPal payment amount does not match the order total.',
            ], 422);
        }

        if ($capture['currency'] !== $checkout['currency']) {
            return response()->json([
                'error' => 'PayPal payment currency does not match the ticket currency.',
            ], 422);
        }

        $paymentId = (string) ($capture['capture_id'] ?? $request->order_id);
        $existingPurchase = TicketPurchase::where('payment_id', $paymentId)->first();
        if ($existingPurchase) {
            return response()->json([
                'redirect' => route('customer.booking.confirmed', $existingPurchase->id),
            ]);
        }

        try {
            $purchase = $this->checkoutService->fulfillPurchase(
                $checkout,
                $request,
                $paymentId,
                'PAYPAL'
            );
        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'error' => 'Payment was captured but order confirmation failed. Please contact support with PayPal reference: ' . $paymentId,
            ], 500);
        }

        return response()->json([
            'redirect' => route('customer.booking.confirmed', $purchase->id),
        ]);
    }
}
