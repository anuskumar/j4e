<?php

namespace App\Http\Controllers;

use App\Models\BankTransferDetail;
use App\Models\Currency;
use App\Models\Events;
use App\Models\EventTickets;
use App\Models\ResellerModel;
use App\Models\SelectedPaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BankTransferController extends Controller
{
    public function storeBankDetails(Request $request)
    {
        $request->validate([
            'currency' => 'required|exists:currency,id',
            'bank_name' => 'required|string|max:255',
            'account_holder_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'routing_number' => 'required|string|max:255',
            'additional_notes' => 'nullable|string',
        ]);

        $resellerId = $this->authenticatedResellerId();
        if (!$resellerId) {
            return redirect()->back()->with(
                'warning',
                'Your reseller profile was not found. Please log in with a reseller account before adding payment details.'
            );
        }

        BankTransferDetail::create([
            'reseller_id' => $resellerId,
            'currency_id' => $request->currency,
            'bank_name' => $request->bank_name,
            'account_holder_name' => $request->account_holder_name,
            'account_number' => $request->account_number,
            'routing_number' => $request->routing_number,
            'additional_notes' => $request->additional_notes,
        ]);

        return redirect()->back()->with('success', 'Bank Transfer Detail saved successfully');
    }

    public function savePaymentMethod(Request $request)
    {
        $resellerId = $this->authenticatedResellerId();
        if (!$resellerId) {
            return redirect()->back()->with(
                'warning',
                'Your reseller profile was not found. Please log in with a reseller account before continuing.'
            );
        }

        $validated = $request->validate([
            'ticket_id' => 'required|exists:event_tickets,id',
            'currency' => 'required|exists:currency,id',
            'amount' => 'required|numeric|min:0',
            'cents' => 'nullable|numeric|min:0|max:99',
            'payment_method' => 'required|exists:bank_transfer_details,id',
        ]);

        $ownsPaymentMethod = BankTransferDetail::where('id', $request->payment_method)
            ->where('reseller_id', $resellerId)
            ->exists();

        if (!$ownsPaymentMethod) {
            return redirect()->back()->withErrors([
                'payment_method' => 'The selected payment method is invalid.',
            ]);
        }

        $ticket = EventTickets::where('id', $validated['ticket_id'])
            ->where('created_by', auth()->id())
            ->firstOrFail();

        $currencyRate = (float) Currency::where('id', $validated['currency'])->value('currency_rate');
        $currencyRate = $currencyRate > 0 ? $currencyRate : 1;
        $enteredPrice = (float) $validated['amount'] + (((float) ($validated['cents'] ?? 0)) / 100);
        $pricePerTicket = round($enteredPrice * $currencyRate, 2);
        $websitePrice = round($pricePerTicket * $ticket->no_of_tickets, 2);
        $sellerFeePercent = (float) optional(Events::find($ticket->event))->seller_fee_percent;
        $sellerFeePercent = $sellerFeePercent > 0 ? $sellerFeePercent : 10;
        $sellerFee = round(($websitePrice * $sellerFeePercent) / 100, 2);
        $receivePerTicket = round($pricePerTicket * (100 - $sellerFeePercent) / 100, 2);
        $totalReceive = round($websitePrice - $sellerFee, 2);

        DB::transaction(function () use (
            $ticket,
            $validated,
            $pricePerTicket,
            $websitePrice,
            $sellerFee,
            $receivePerTicket,
            $totalReceive,
            $resellerId
        ) {
            $ticket->update([
                'amount_currency' => $validated['currency'],
                'ticket_amount' => $pricePerTicket,
                'web_price' => $websitePrice,
                'seller_fee' => $sellerFee,
                'recive_perticket' => $receivePerTicket,
                'total_recive' => $totalReceive,
            ]);

            SelectedPaymentMethod::updateOrCreate(
                ['reseller_id' => $resellerId],
                [
                    'payment_type' => 'bank_transfer',
                    'payment_id' => $validated['payment_method'],
                ]
            );
        });

        return view('reseller.reseller_success')->with('success', 'Your Ticket Has been created');
    }

    private function authenticatedResellerId(): ?int
    {
        $resellerId = ResellerModel::where('user_id', auth()->id())->value('id');

        return $resellerId ? (int) $resellerId : null;
    }
}
