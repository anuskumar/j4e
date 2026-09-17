<?php

namespace App\Console\Commands;

use App\Services\ExchangeRateService;
use Illuminate\Console\Command;
use Throwable;

class UpdateCurrencyRates extends Command
{
    protected $signature = 'currency:update-rates {--fresh : Bypass cached API rates}';

    protected $description = 'Update stored currency conversion rates against USD using ExchangeRate-API';

    public function handle(ExchangeRateService $exchangeRateService): int
    {
        try {
            $result = $exchangeRateService->syncStoredCurrencyRates((bool) $this->option('fresh'));

            $this->info("Currency rates updated successfully. Updated: {$result['updated']}, skipped: {$result['skipped']}.");
            if (! empty($result['source_updated_at'])) {
                $this->line('Source last update: '.$result['source_updated_at']);
            }

            return self::SUCCESS;
        } catch (Throwable $e) {
            $this->error('Error updating currency rates: '.$e->getMessage());

            return self::FAILURE;
        }
    }
}
