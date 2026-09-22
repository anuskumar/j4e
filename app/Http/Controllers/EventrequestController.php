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
            'website_url' => 'nullable|url|max:500',
            'location_details' => 'nullable|string|max:2000',
            'venue_details' => 'nullable|string|max:255',
            'event_date' => 'required|date',
            'city' => 'nullable|string|max:255',
            'artist_names' => 'nullable|array',
            'artist_names.*' => 'nullable|string|max:120',
            'event_details' => 'nullable|string|max:5000',
        ], [
            'name.required' => 'Please enter your full name.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'phone.required' => 'Please enter your phone number.',
            'website_url.url' => 'Please enter a valid website URL (including https://).',
            'event_date.required' => 'Please select the event date.',
        ]);

        $artists = collect($validated['artist_names'] ?? [])
            ->map(fn ($name) => trim((string) $name))
            ->filter()
            ->unique()
            ->values()
            ->all();

        $data = new RequestEventModel();
        $data->name = $validated['name'];
        $data->email = $validated['email'];
        $data->phone = $validated['phone'];
        $data->website_url = $validated['website_url'] ?? null;
        $data->location_details = $validated['location_details'];
        $data->venue_details = $validated['venue_details'];
        $data->event_date = $validated['event_date'];
        $data->city = $validated['city'];
        $data->artist_names = $artists ?: null;
        $data->event_details = $validated['event_details'] ?? null;
        $data->save();

        app(NotificationService::class)->notifyEventRequest($data);

        return redirect()->route('reseller.requestevent.thankyou');
    }
}
