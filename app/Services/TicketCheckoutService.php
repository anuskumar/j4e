<?php

namespace App\Services;

use App\Models\Currency;
use App\Models\EventTickets;
use App\Models\Events;
use App\Models\EventTiming;
use App\Models\OrderStatusUpdate;
use App\Models\TicketPurchase;
use App\Models\TicketsGenerated;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class TicketCheckoutService
{
    public function prepareCheckout(Request $request, string $errorField = 'cardError'): array
    {
        $currency = strtolower($request->currency_name);
        $requestedCount = (int) $request->total_number;
        $amount = (float) $request->payment_amount;

        if ($amount <= 0) {
            return $this->error($errorField, 'Invalid payment amount. Please check the ticket price and quantity.');
        }

        $eventTicket = EventTickets::find($request->event_ticket_id);
        if (! $eventTicket) {
            return $this->error($errorField, 'Selected ticket is not available.');
        }

        if ((int) $eventTicket->event !== (int) $request->event_id) {
            return $this->error($errorField, 'Invalid event selection for this ticket.');
        }

        $holdValidFrom = now()->subMinutes(15);
        $heldTicketsQuery = TicketsGenerated::where('event_tickets', $request->event_ticket_id)
            ->where('user_id', Auth::id())
            ->where('is_sold', 0)
            ->where('under_purchase_hold', 1)
            ->where('purchase_hold_time', '>=', $holdValidFrom)
            ->orderBy('id');

        $heldCount = (int) $heldTicketsQuery->count();

        if ($heldCount < 1) {
            return $this->error($errorField, 'Your ticket hold has expired. Please select tickets again.');
        }

        if ($requestedCount > $heldCount) {
            $reserveResult = $this->reserveAdditionalTickets(
                $request->event_ticket_id,
                $requestedCount,
                $heldCount,
                $holdValidFrom,
                $errorField
            );

            if (isset($reserveResult['errors'])) {
                return $reserveResult;
            }

            $heldCount = $reserveResult['held_count'];
        }

        if ($requestedCount > $heldCount) {
            return $this->error($errorField, 'Unable to reserve requested quantity. Please try again.');
        }

        $unitPrice = (float) ($eventTicket->ticket_amount ?? 0);
        $expectedAmount = round($unitPrice * $requestedCount, 2);

        return [
            'event_ticket' => $eventTicket,
            'event_id' => (int) $request->event_id,
            'event_ticket_id' => (int) $request->event_ticket_id,
            'requested_count' => $requestedCount,
            'expected_amount' => $expectedAmount,
            'currency' => $currency,
            'hold_valid_from' => $holdValidFrom,
        ];
    }

    public function fulfillPurchase(array $checkout, Request $request, string $paymentId, ?string $paymentCardLast4): TicketPurchase
    {
        $existingPurchase = TicketPurchase::where('payment_id', $paymentId)->first();
        if ($existingPurchase) {
            return $existingPurchase;
        }

        DB::beginTransaction();

        try {
            $eventTicket = $checkout['event_ticket'];
            $requestedCount = $checkout['requested_count'];
            $expectedAmount = $checkout['expected_amount'];
            $currency = $checkout['currency'];
            $holdValidFrom = $checkout['hold_valid_from'];

            $heldTicketsQuery = TicketsGenerated::where('event_tickets', $checkout['event_ticket_id'])
                ->where('user_id', Auth::id())
                ->where('is_sold', 0)
                ->where('under_purchase_hold', 1)
                ->where('purchase_hold_time', '>=', $holdValidFrom)
                ->orderBy('id');

            $currencyId = $this->resolveCurrencyId($currency, $eventTicket);

            $ticket = new TicketPurchase();
            $ticket->event_id = $checkout['event_id'];
            $ticket->event_ticket_id = $checkout['event_ticket_id'];
            $ticket->total_number = $requestedCount;
            $ticket->shipping_name = $request->shipping_name;
            $ticket->shipping_address1 = $request->shipping_address1;
            $ticket->shipping_address2 = $request->shipping_address2;
            $ticket->shipping_country = $request->shipping_country;
            $ticket->shipping_city = $request->shipping_city;
            $ticket->shipping_pincode = $request->shipping_pincode;
            $ticket->accepted_tearms_condetion = $request->accepted_tearms_condetion ? true : false;
            $ticket->payment_amount = $expectedAmount;
            $ticket->payment_currency = $currencyId;
            $ticket->payment_card_number = $paymentCardLast4;
            $ticket->purchase_status = 1;
            $ticket->payment_date = date('Y-m-d H:i:s');
            $ticket->is_payment_completed = 1;
            $ticket->payment_id = $paymentId;
            $ticket->user_id = Auth::id();
            $ticket->save();

            $ticketCount = $heldTicketsQuery->take($requestedCount)->get();
            $remainingHeldTickets = TicketsGenerated::where('event_tickets', $checkout['event_ticket_id'])
                ->where('user_id', Auth::id())
                ->where('is_sold', 0)
                ->where('under_purchase_hold', 1)
                ->where('purchase_hold_time', '>=', $holdValidFrom)
                ->whereNotIn('id', $ticketCount->pluck('id'))
                ->get();

            $soldCount = $ticketCount->count();

            foreach ($ticketCount as $count) {
                $generated = TicketsGenerated::find($count->id);
                $generated->purchase_id = $ticket->id;
                $generated->is_sold = 1;
                $generated->under_purchase_hold = 0;
                $generated->purchase_hold_time = null;
                $generated->purchase_date = date('Y-m-d H:i:s');
                $generated->save();
            }

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
            $orderStatus->created_by = Auth::id();
            $orderStatus->save();

            $event = Events::where('id', $checkout['event_id'])->first();
            $eventTickets = EventTickets::where('id', $checkout['event_ticket_id'])->first();
            $userData = User::where('id', $eventTickets->created_by)->first();
            $customerUser = Auth::user();
            $currencyCode = strtoupper($currency);
            $totalPaid = number_format((float) $expectedAmount, 2);
            $eventName = (string) ($event->event_name ?? '');
            $eventTiming = $eventTickets && $eventTickets->event_timing
                ? EventTiming::find($eventTickets->event_timing)
                : null;
            $eventDate = $eventTiming && $eventTiming->event_date
                ? date('d M Y', strtotime($eventTiming->event_date))
                : (string) ($event->event_from_date ?? '');
            $ticketName = (string) ($eventTickets->ticket_name ?? '');

            if ($userData) {
                try {
                    app(NotificationService::class)->notifyNewOrder(
                        $ticket,
                        $eventName,
                        (string) ($customerUser->name ?? 'Customer'),
                        (int) $userData->id
                    );
                } catch (\Exception $notificationException) {
                    report($notificationException);
                }
            }

            DB::commit();

            $this->sendPurchaseConfirmationEmails(
                $ticket,
                $customerUser,
                $userData,
                $eventName,
                $eventDate,
                $ticketName,
                $soldCount,
                $totalPaid,
                $currencyCode
            );

            return $ticket;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function shippingRules(): array
    {
        return [
            'shipping_name' => 'required|string|max:255',
            'shipping_address1' => 'required|string|max:500',
            'shipping_address2' => 'nullable|string|max:500',
            'shipping_country' => 'required|numeric|exists:countries,id',
            'shipping_city' => 'required|string|max:255',
            'shipping_pincode' => 'required|string|max:20',
            'payment_amount' => 'required|numeric|min:0',
            'event_id' => 'required|numeric|exists:event,id',
            'event_ticket_id' => 'required|numeric|exists:event_tickets,id',
            'total_number' => 'required|numeric|min:1',
            'currency_name' => 'required|string',
        ];
    }

    public function shippingMessages(): array
    {
        return [
            'shipping_name.required' => 'Please enter your name.',
            'shipping_address1.required' => 'Please enter your address.',
            'shipping_country.required' => 'Please select a country.',
            'shipping_country.exists' => 'Please select a valid country.',
            'shipping_city.required' => 'Please enter your city.',
            'shipping_pincode.required' => 'Please enter your pincode.',
        ];
    }

    private function reserveAdditionalTickets(
        int $eventTicketId,
        int $requestedCount,
        int $heldCount,
        $holdValidFrom,
        string $errorField
    ): array {
        $additionalNeeded = $requestedCount - $heldCount;

        $additionalTickets = TicketsGenerated::where('event_tickets', $eventTicketId)
            ->where('is_sold', 0)
            ->where('under_purchase_hold', 0)
            ->orderBy('id')
            ->take($additionalNeeded)
            ->lockForUpdate()
            ->get();

        if ($additionalTickets->count() < $additionalNeeded) {
            $maxAvailableNow = $heldCount + $additionalTickets->count();

            return $this->error($errorField, "Only {$maxAvailableNow} ticket(s) are available right now.");
        }

        foreach ($additionalTickets as $additionalTicket) {
            $additionalTicket->user_id = Auth::id();
            $additionalTicket->under_purchase_hold = 1;
            $additionalTicket->purchase_hold_time = now();
            $additionalTicket->save();
        }

        $heldCount = (int) TicketsGenerated::where('event_tickets', $eventTicketId)
            ->where('user_id', Auth::id())
            ->where('is_sold', 0)
            ->where('under_purchase_hold', 1)
            ->where('purchase_hold_time', '>=', $holdValidFrom)
            ->count();

        return ['held_count' => $heldCount];
    }

    private function error(string $field, string $message): array
    {
        return ['errors' => [$field => $message]];
    }

    private function resolveCurrencyId(string $currencyCode, ?EventTickets $eventTicket = null): ?int
    {
        $currencyCode = strtoupper(trim($currencyCode));

        $record = Currency::whereRaw('UPPER(short_name) = ?', [$currencyCode])->first();
        if ($record) {
            return (int) $record->id;
        }

        if ($eventTicket && $eventTicket->amount_currency) {
            return (int) $eventTicket->amount_currency;
        }

        return null;
    }

    private function sendPurchaseConfirmationEmails(
        TicketPurchase $ticket,
        ?User $customerUser,
        ?User $resellerUser,
        string $eventName,
        string $eventDate,
        string $ticketName,
        int $soldCount,
        string $totalPaid,
        string $currencyCode
    ): void {
        $purchaseId = (int) $ticket->id;
        $invoiceService = app(PurchaseInvoiceService::class);
        $invoiceFilename = $invoiceService->getInvoiceFilename($purchaseId);

        try {
            $invoicePdf = $invoiceService->generatePdfBinary($purchaseId);
        } catch (\Exception $invoiceException) {
            report($invoiceException);
            $invoicePdf = null;
        }

        if ($customerUser && ! empty($customerUser->email)) {
            try {
                $customerHtml = '
                    <h2>Congratulations! Your Booking Is Confirmed</h2>
                    <p>Hi ' . e($customerUser->name ?? 'Customer') . ',</p>
                    <p>Thank you for your purchase. Your payment was successful and your booking has been confirmed.</p>
                    <ul>
                        <li><strong>Order ID:</strong> #' . str_pad((string) $purchaseId, 6, '0', STR_PAD_LEFT) . '</li>
                        <li><strong>Event:</strong> ' . e($eventName) . '</li>
                        <li><strong>Event Date:</strong> ' . e($eventDate) . '</li>
                        <li><strong>Ticket:</strong> ' . e($ticketName) . '</li>
                        <li><strong>Ticket Count:</strong> ' . $soldCount . '</li>
                        <li><strong>Total Amount:</strong> ' . $totalPaid . ' ' . e($currencyCode) . '</li>
                        <li><strong>Payment Reference:</strong> ' . e($ticket->payment_id ?? 'N/A') . '</li>
                    </ul>
                    <p>Your invoice is attached to this email. You can also view your booking anytime from your account dashboard.</p>
                ';

                Mail::html($customerHtml, function ($message) use ($customerUser, $purchaseId, $invoicePdf, $invoiceFilename) {
                    $message->to($customerUser->email)
                        ->subject('Booking Confirmed #' . str_pad((string) $purchaseId, 6, '0', STR_PAD_LEFT));

                    if ($invoicePdf) {
                        $message->attachData($invoicePdf, $invoiceFilename, [
                            'mime' => 'application/pdf',
                        ]);
                    }
                });
            } catch (\Exception $customerMailException) {
                report($customerMailException);
            }
        }

        if ($resellerUser && ! empty($resellerUser->email)) {
            try {
                $resellerHtml = '
                    <h2>New Ticket Booking Confirmed</h2>
                    <p>Hi ' . e($resellerUser->name ?? 'Reseller') . ',</p>
                    <p>A customer booking has been confirmed and payment was received successfully.</p>
                    <ul>
                        <li><strong>Order ID:</strong> #' . str_pad((string) $purchaseId, 6, '0', STR_PAD_LEFT) . '</li>
                        <li><strong>Customer:</strong> ' . e($customerUser->name ?? 'Customer') . '</li>
                        <li><strong>Customer Email:</strong> ' . e($customerUser->email ?? 'N/A') . '</li>
                        <li><strong>Event:</strong> ' . e($eventName) . '</li>
                        <li><strong>Event Date:</strong> ' . e($eventDate) . '</li>
                        <li><strong>Ticket:</strong> ' . e($ticketName) . '</li>
                        <li><strong>Ticket Count:</strong> ' . $soldCount . '</li>
                        <li><strong>Total Amount:</strong> ' . $totalPaid . ' ' . e($currencyCode) . '</li>
                        <li><strong>Payment Reference:</strong> ' . e($ticket->payment_id ?? 'N/A') . '</li>
                    </ul>
                    <p>Please review the order in your reseller dashboard and proceed with fulfillment.</p>
                ';

                Mail::html($resellerHtml, function ($message) use ($resellerUser, $purchaseId) {
                    $message->to($resellerUser->email)
                        ->subject('New Booking Confirmed #' . str_pad((string) $purchaseId, 6, '0', STR_PAD_LEFT));
                });
            } catch (\Exception $resellerMailException) {
                report($resellerMailException);
            }
        }
    }
}
