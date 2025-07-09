<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Currency;
use GuzzleHttp\Client;

class UpdateCurrencyRates extends Command
{
    protected $signature = 'currency:update-rates';
    protected $description = 'Update currency conversion rates using ExchangeRate-API';

    public function handle()
    {
        $apiKey = config('services.exchangerate.api_key'); 
        $baseCurrency = 'USD';
        $endpoint = "https://v6.exchangerate-api.com/v6/{$apiKey}/latest/{$baseCurrency}";

        $client = new Client();

        try {
            $response = $client->get($endpoint);
            $data = json_decode($response->getBody(), true);

            if ($data['result'] === 'success') {
                $currencies = Currency::pluck('short_name')->toArray();

                foreach ($currencies as $currency) {
                    if (isset($data['conversion_rates'][$currency])) {
                        Currency::where('short_name', $currency)
                            ->update(['currency_rate' => $data['conversion_rates'][$currency]]);
                    }
                }

                $this->info('Currency rates updated successfully.');
            } else {
                $this->error('Failed to fetch currency rates: ' . $data['error-type']);
            }
        } catch (\Exception $e) {
            $this->error('Error fetching currency rates: ' . $e->getMessage());
        }
    }
}
