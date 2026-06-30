<?php

namespace App\Console\Commands;

use App\Models\TicketsGenerated;
use Illuminate\Console\Command;

class ticket_reload_timer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:ticket_reload_timer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Release ticket checkout holds older than 15 minutes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $released = TicketsGenerated::releaseExpiredHolds();

        $this->info("Released {$released} expired ticket hold(s).");
    }
}
