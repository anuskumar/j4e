<?php

namespace App\Services;

use App\Models\PaypalSetting;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class PaypalService
{
    public function settings(): PaypalSetting
    {
        return PaypalSetting::current();
    }

    public static function make(): self
    {
        return new self();
    }

    public function isReady(): bool
    {
        return $this->settings()->isConfigured();
    }

    public function clientId(): string
    {
        return (string) $this->settings()->client_id;
    }

    public function sdkUrl(string $currency): string
    {
        $settings = $this->settings();
        $host = $settings->mode === 'live'
            ? 'https://www.paypal.com'
            : 'https://www.sandbox.paypal.com';

        return $host . '/sdk/js?' . http_build_query([
            'client-id' => $settings->client_id,
            'currency' => strtoupper($currency),
            'intent' => 'capture',
        ]);
    }

    public function createOrder(float $amount, string $currency, array $metadata = []): string
    {
        $settings = $this->settings();
        $token = $this->accessToken();
        $reference = collect($metadata)->map(fn ($value, $key) => $key . ':' . $value)->implode('|');

        $response = Http::withToken($token)
            ->acceptJson()
            ->post($settings->apiBaseUrl() . '/v2/checkout/orders', [
                'intent' => 'CAPTURE',
                'purchase_units' => [[
                    'amount' => [
                        'currency_code' => strtoupper($currency),
                        'value' => number_format($amount, 2, '.', ''),
                    ],
                    'custom_id' => substr($reference, 0, 127),
                ]],
            ]);

        if (! $response->successful()) {
            throw new RuntimeException($this->extractErrorMessage($response->json(), 'Unable to create PayPal order.'));
        }

        $orderId = $response->json('id');
        if (! $orderId) {
            throw new RuntimeException('PayPal did not return an order ID.');
        }

        return $orderId;
    }

    public function captureOrder(string $orderId): array
    {
        $token = $this->accessToken();

        $response = Http::withToken($token)
            ->acceptJson()
            ->withHeaders(['Prefer' => 'return=representation'])
            ->post($this->settings()->apiBaseUrl() . '/v2/checkout/orders/' . $orderId . '/capture');

        if (! $response->successful()) {
            throw new RuntimeException($this->extractErrorMessage($response->json(), 'Unable to capture PayPal payment.'));
        }

        return $response->json();
    }

    public function extractCaptureDetails(array $captureResponse): array
    {
        $status = $captureResponse['status'] ?? null;
        $purchaseUnit = $captureResponse['purchase_units'][0] ?? [];
        $capture = $purchaseUnit['payments']['captures'][0] ?? [];
        $captureStatus = $capture['status'] ?? null;
        $captureId = $capture['id'] ?? null;
        $amountValue = isset($capture['amount']['value']) ? (float) $capture['amount']['value'] : null;
        $currencyCode = strtolower($capture['amount']['currency_code'] ?? '');

        return [
            'order_status' => $status,
            'capture_status' => $captureStatus,
            'capture_id' => $captureId,
            'amount' => $amountValue,
            'currency' => $currencyCode,
        ];
    }

    private function accessToken(): string
    {
        $settings = $this->settings();

        if (! $this->isReady()) {
            throw new RuntimeException('PayPal is not configured.');
        }

        $response = Http::asForm()
            ->withBasicAuth($settings->client_id, $settings->client_secret)
            ->post($settings->apiBaseUrl() . '/v1/oauth2/token', [
                'grant_type' => 'client_credentials',
            ]);

        if (! $response->successful()) {
            throw new RuntimeException('PayPal authentication failed. Check admin integration settings.');
        }

        $token = $response->json('access_token');
        if (! $token) {
            throw new RuntimeException('PayPal authentication token missing.');
        }

        return $token;
    }

    private function extractErrorMessage(?array $payload, string $fallback): string
    {
        if (! is_array($payload)) {
            return $fallback;
        }

        if (! empty($payload['message'])) {
            return (string) $payload['message'];
        }

        $detail = $payload['details'][0]['description'] ?? $payload['details'][0]['issue'] ?? null;
        if ($detail) {
            return (string) $detail;
        }

        return $fallback;
    }
}
