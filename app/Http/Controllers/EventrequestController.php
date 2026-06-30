<?php

namespace App\Http\Controllers;

use App\Models\RequestEventModel;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class EventrequestController extends Controller
{
    public function requestevent()
    {
        return view('request_event.form');
    }

    public function requesteventThankYou()
    {
        return view('request_event.thankyou');
    }

    public function requesteventstore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:50',
            'event_details' => 'required|string|max:5000',
        ], [
            'name.required' => 'Please enter your full name.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'phone.required' => 'Please enter your phone number.',
            'event_details.required' => 'Please describe the event you want to request.',
        ]);

        $data = new RequestEventModel();
        $data->name = $validated['name'];
        $data->email = $validated['email'];
        $data->event_details = $validated['event_details'];
        $data->phone = $validated['phone'];
        $data->save();

        app(NotificationService::class)->notifyEventRequest($data);

        return redirect()->route('reseller.requestevent.thankyou');
    }
}
