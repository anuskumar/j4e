<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Services\ExchangeRateService;
use Illuminate\Http\Request;
use Throwable;

class CurrencyController extends Controller
{
    public function __construct(private ExchangeRateService $exchangeRateService)
    {
    }

    public function index()
    {
        $data = Currency::orderByDesc('is_active')
            ->orderBy('name')
            ->get();

        $existingCodes = $data->pluck('short_name')
            ->filter()
            ->map(fn ($code) => strtoupper(trim($code)))
            ->unique()
            ->values()
            ->all();

        $availableCurrencies = [];
        $catalogError = null;
        $ratesMeta = null;

        try {
            $supported = $this->exchangeRateService->getSupportedCurrencies();
            $ratesMeta = $this->exchangeRateService->getLatestUsdRates();

            foreach ($supported as $code => $name) {
                if (in_array($code, $existingCodes, true)) {
                    continue;
                }
                $availableCurrencies[$code] = $name;
            }
        } catch (Throwable $e) {
            $catalogError = $e->getMessage();
        }

        return view('admin.currency.list', compact(
            'data',
            'availableCurrencies',
            'catalogError',
            'ratesMeta'
        ));
    }

    public function preview(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:10',
        ]);

        try {
            $details = $this->exchangeRateService->getCurrencyDetails($validated['code']);

            return response()->json([
                'success' => true,
                'data' => $details,
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function storeFromCatalog(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:10',
            'is_active' => 'nullable|in:0,1',
        ]);

        $code = strtoupper(trim($validated['code']));

        $exists = Currency::withTrashed()
            ->whereRaw('UPPER(short_name) = ?', [$code])
            ->first();

        if ($exists && ! $exists->trashed()) {
            return redirect('currency/list')->with('error', "Currency [{$code}] is already in your list.");
        }

        try {
            $details = $this->exchangeRateService->getCurrencyDetails($code);
        } catch (Throwable $e) {
            return redirect('currency/list')->with('error', $e->getMessage());
        }

        if ($exists && $exists->trashed()) {
            $exists->restore();
            $exists->name = $details['name'];
            $exists->short_name = $details['code'];
            $exists->symbol = $details['symbol'];
            $exists->currency_rate = $details['rate'];
            $exists->rate_updated_at = now();
            $exists->is_active = (int) ($validated['is_active'] ?? 1);
            $exists->save();
        } else {
            Currency::create([
                'name' => $details['name'],
                'short_name' => $details['code'],
                'symbol' => $details['symbol'],
                'currency_rate' => $details['rate'],
                'rate_updated_at' => now(),
                'is_active' => (int) ($validated['is_active'] ?? 1),
            ]);
        }

        return redirect('currency/list')->with('success', "{$details['name']} ({$details['code']}) added to your active currency list.");
    }

    public function syncRates()
    {
        try {
            $result = $this->exchangeRateService->syncStoredCurrencyRates(true);

            return redirect('currency/list')->with(
                'success',
                "Exchange rates refreshed. Updated {$result['updated']} currencies."
            );
        } catch (Throwable $e) {
            return redirect('currency/list')->with('error', $e->getMessage());
        }
    }

    public function show(string $id)
    {
        $data = Currency::find($id);

        return view('admin.currency.view', compact('data'));
    }

    public function create()
    {
        return redirect('currency/list');
    }

    public function edit(string $id)
    {
        $data = Currency::find($id);

        return view('admin.currency.edit', compact('data'));
    }

    public function store(Request $request)
    {
        return $this->storeFromCatalog($request);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer|exists:currency,id',
            'name' => 'required|string|max:255',
            'short_name' => 'required|string|max:10',
            'symbol' => 'nullable|string|max:20',
            'is_active' => 'nullable|in:0,1',
        ]);

        $data = Currency::findOrFail($validated['id']);
        $data->name = $validated['name'];
        $data->short_name = strtoupper(trim($validated['short_name']));
        $data->symbol = $validated['symbol'] ?? $data->symbol;
        $data->is_active = (int) ($validated['is_active'] ?? $data->is_active);

        // Keep live rate in sync when short name is valid.
        try {
            $details = $this->exchangeRateService->getCurrencyDetails($data->short_name);
            $data->currency_rate = $details['rate'];
            $data->rate_updated_at = now();
            if (empty($data->symbol)) {
                $data->symbol = $details['symbol'];
            }
        } catch (Throwable $e) {
            // Keep existing rate if API lookup fails.
        }

        $data->save();

        return redirect('currency/list')->with('success', 'Currency updated successfully.');
    }

    public function delete($id)
    {
        $data = Currency::find($id);
        if ($data) {
            $data->delete();
        }

        return redirect('/currency/list')->with('success', 'Currency removed from your list.');
    }

    public function getRate($id)
    {
        $currency = Currency::find($id);

        if (! $currency) {
            return response()->json(['error' => 'Currency not found'], 404);
        }

        return response()->json([
            'rate' => round((float) $currency->currency_rate, 6),
            'code' => $currency->short_name,
            'symbol' => $currency->symbol,
        ]);
    }
}
