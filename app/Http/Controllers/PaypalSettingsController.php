<?php

namespace App\Http\Controllers;

use App\Models\PaypalSetting;
use Illuminate\Http\Request;

class PaypalSettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'user.type:superadmin']);
    }

    public function index()
    {
        $settings = PaypalSetting::current();

        return view('admin.paypal.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'nullable|string|max:255',
            'client_secret' => 'nullable|string|max:500',
            'mode' => 'required|in:sandbox,live',
            'is_enabled' => 'nullable|boolean',
            'webhook_id' => 'nullable|string|max:255',
            'merchant_email' => 'nullable|email|max:255',
        ]);

        $settings = PaypalSetting::current();
        $isEnabled = $request->boolean('is_enabled');

        if ($isEnabled && empty($validated['client_id'])) {
            return back()
                ->withErrors(['client_id' => 'Client ID is required when PayPal is enabled.'])
                ->withInput();
        }

        if ($isEnabled && empty($validated['client_secret']) && empty($settings->client_secret)) {
            return back()
                ->withErrors(['client_secret' => 'Client Secret is required when PayPal is enabled.'])
                ->withInput();
        }

        $settings->client_id = $validated['client_id'] ?? null;
        $settings->mode = $validated['mode'];
        $settings->is_enabled = $isEnabled;
        $settings->webhook_id = $validated['webhook_id'] ?? null;
        $settings->merchant_email = $validated['merchant_email'] ?? null;

        if (! empty($validated['client_secret'])) {
            $settings->client_secret = $validated['client_secret'];
        }

        $settings->save();

        return redirect()
            ->route('admin.paypal.settings')
            ->with('success', 'PayPal integration settings saved successfully.');
    }
}
