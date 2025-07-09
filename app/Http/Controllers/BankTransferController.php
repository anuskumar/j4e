<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BankTransferDetail;
use App\Models\SelectedPaymentMethod;

class BankTransferController extends Controller
{
    public function storeBankDetails(Request $request)
    {
        $request->validate([
            'currency' => 'required', // Validate that the currency ID is provided
            'bank_name' => 'required',
            'account_holder_name' => 'required',
            'account_number' => 'required',
            'routing_number' => 'required',
            'additional_notes' => 'nullable'
        ]);

        BankTransferDetail::updateOrCreate(
            ['reseller_id' => auth()->id()],
            [
                'currency_id' => $request->currency, // Store the currency ID in the currency column
                'bank_name' => $request->bank_name,
                'account_holder_name' => $request->account_holder_name,
                'account_number' => $request->account_number,
                'routing_number' => $request->routing_number,
                'additional_notes' => $request->additional_notes,
            ]
        );

        return redirect()->back()->with('success', 'Bank Transfer Detail saved successfully');
    }

    public function savePaymentMethod(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|exists:bank_transfer_details,id'
        ]);

        SelectedPaymentMethod::updateOrCreate(
            ['reseller_id' => auth()->id()],
            [
                'payment_type' => $request->payment_type,
                'payment_id' => $request->payment_method
            ]
        );
        return view('reseller.reseller_success')->with('success', 'Your Ticket Has been created');
    }
}
