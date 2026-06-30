<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaypalSetting extends Model
{
    protected $table = 'paypal_settings';

    protected $fillable = [
        'client_id',
        'client_secret',
        'mode',
        'is_enabled',
        'webhook_id',
        'merchant_email',
    ];

    protected $casts = [
        'client_secret' => 'encrypted',
        'is_enabled' => 'boolean',
    ];

    public static function current(): self
    {
        return static::firstOrCreate([], [
            'mode' => 'sandbox',
            'is_enabled' => false,
        ]);
    }

    public function isConfigured(): bool
    {
        return $this->is_enabled
            && filled($this->client_id)
            && filled($this->client_secret);
    }

    public function apiBaseUrl(): string
    {
        return $this->mode === 'live'
            ? 'https://api-m.paypal.com'
            : 'https://api-m.sandbox.paypal.com';
    }

    public function modeLabel(): string
    {
        return $this->mode === 'live' ? 'Live' : 'Sandbox';
    }
}
