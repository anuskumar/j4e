<?php

namespace App\Services;

use App\Models\Currency;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use RuntimeException;

class ExchangeRateService
{
    private const CACHE_CODES_KEY = 'exchangerate.supported_codes';

    private const CACHE_RATES_KEY = 'exchangerate.usd_rates';

    private const CACHE_TTL_SECONDS = 21600; // 6 hours

    public function apiKey(): string
    {
        $apiKey = (string) config('services.exchangerate.api_key');

        if ($apiKey === '') {
            throw new RuntimeException('EXCHANGE_RATE_API_KEY is not configured.');
        }

        return $apiKey;
    }

    /**
     * @return array<string, string> code => name
     */
    public function getSupportedCurrencies(bool $forceRefresh = false): array
    {
        if ($forceRefresh) {
            Cache::forget(self::CACHE_CODES_KEY);
        }

        return Cache::remember(self::CACHE_CODES_KEY, self::CACHE_TTL_SECONDS, function () {
            $response = Http::timeout(20)
                ->get("https://v6.exchangerate-api.com/v6/{$this->apiKey()}/codes");

            if (! $response->successful()) {
                throw new RuntimeException('Unable to fetch supported currencies from ExchangeRate-API.');
            }

            $payload = $response->json();
            if (($payload['result'] ?? null) !== 'success' || empty($payload['supported_codes'])) {
                throw new RuntimeException('ExchangeRate-API returned an invalid currency codes response.');
            }

            $currencies = [];
            foreach ($payload['supported_codes'] as $row) {
                if (! is_array($row) || count($row) < 2) {
                    continue;
                }
                $code = strtoupper(trim((string) $row[0]));
                $name = trim((string) $row[1]);
                if ($code !== '' && $name !== '') {
                    $currencies[$code] = $name;
                }
            }

            ksort($currencies);

            return $currencies;
        });
    }

    /**
     * @return array{base: string, rates: array<string, float>, updated_at: string|null, next_update_at: string|null}
     */
    public function getLatestUsdRates(bool $forceRefresh = false): array
    {
        if ($forceRefresh) {
            Cache::forget(self::CACHE_RATES_KEY);
        }

        return Cache::remember(self::CACHE_RATES_KEY, self::CACHE_TTL_SECONDS, function () {
            $response = Http::timeout(20)
                ->get("https://v6.exchangerate-api.com/v6/{$this->apiKey()}/latest/USD");

            if (! $response->successful()) {
                throw new RuntimeException('Unable to fetch USD exchange rates from ExchangeRate-API.');
            }

            $payload = $response->json();
            if (($payload['result'] ?? null) !== 'success' || empty($payload['conversion_rates'])) {
                throw new RuntimeException('ExchangeRate-API returned an invalid rates response.');
            }

            $rates = [];
            foreach ($payload['conversion_rates'] as $code => $rate) {
                $rates[strtoupper((string) $code)] = (float) $rate;
            }

            return [
                'base' => 'USD',
                'rates' => $rates,
                'updated_at' => $payload['time_last_update_utc'] ?? null,
                'next_update_at' => $payload['time_next_update_utc'] ?? null,
            ];
        });
    }

    /**
     * @return array{code: string, name: string, symbol: string, rate: float, updated_at: string|null}
     */
    public function getCurrencyDetails(string $code): array
    {
        $code = strtoupper(trim($code));
        $supported = $this->getSupportedCurrencies();
        $ratesPayload = $this->getLatestUsdRates();

        if (! isset($supported[$code])) {
            throw new RuntimeException("Currency code [{$code}] is not supported.");
        }

        if (! isset($ratesPayload['rates'][$code])) {
            throw new RuntimeException("Exchange rate for [{$code}] is not available.");
        }

        return [
            'code' => $code,
            'name' => $supported[$code],
            'symbol' => $this->resolveSymbol($code),
            'rate' => (float) $ratesPayload['rates'][$code],
            'updated_at' => $ratesPayload['updated_at'],
        ];
    }

    /**
     * @return array{updated: int, skipped: int, source_updated_at: string|null}
     */
    public function syncStoredCurrencyRates(bool $forceRefresh = true): array
    {
        $ratesPayload = $this->getLatestUsdRates($forceRefresh);
        $hasRateUpdatedAt = Schema::hasColumn('currency', 'rate_updated_at');
        $updated = 0;
        $skipped = 0;

        foreach (Currency::query()->get() as $currency) {
            $code = strtoupper(trim((string) $currency->short_name));
            if ($code === '' || ! isset($ratesPayload['rates'][$code])) {
                $skipped++;
                continue;
            }

            $currency->currency_rate = $ratesPayload['rates'][$code];
            if ($hasRateUpdatedAt) {
                $currency->rate_updated_at = now();
            }
            $currency->save();
            $updated++;
        }

        return [
            'updated' => $updated,
            'skipped' => $skipped,
            'source_updated_at' => $ratesPayload['updated_at'],
        ];
    }

    public function resolveSymbol(string $code): string
    {
        $code = strtoupper(trim($code));

        static $fallback = [
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            'INR' => '₹',
            'JPY' => '¥',
            'CNY' => '¥',
            'AUD' => 'A$',
            'CAD' => 'C$',
            'CHF' => 'CHF',
            'AED' => 'د.إ',
            'SAR' => '﷼',
        ];

        if (class_exists(\NumberFormatter::class)) {
            try {
                $formatter = new \NumberFormatter('en', \NumberFormatter::CURRENCY);
                $formatter->setTextAttribute(\NumberFormatter::CURRENCY_CODE, $code);
                $symbol = $formatter->getSymbol(\NumberFormatter::CURRENCY_SYMBOL);
                if (is_string($symbol) && $symbol !== '' && strtoupper($symbol) !== $code) {
                    return $symbol;
                }
            } catch (\Throwable $e) {
                Log::debug('Currency symbol lookup failed for '.$code.': '.$e->getMessage());
            }
        }

        return $fallback[$code] ?? $code;
    }
}
