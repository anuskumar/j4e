<?php

namespace App\Http\Controllers;

use App\Models\BankTransferDetail;
use App\Models\ResellerModel;
use App\Models\SelectedPaymentMethod;
use Illuminate\Http\Request;

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

        $request->validate([
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

        SelectedPaymentMethod::updateOrCreate(
            ['reseller_id' => $resellerId],
            [
                'payment_type' => $request->payment_type,
                'payment_id' => $request->payment_method,
            ]
        );

        return view('reseller.reseller_success')->with('success', 'Your Ticket Has been created');
    }

    private function authenticatedResellerId(): int
    {
        $resellerId = ResellerModel::where('user_id', auth()->id())->value('id');

        if (!$resellerId) {
            abort(403, 'Reseller profile not found.');
        }

        return (int) $resellerId;
    }
}
