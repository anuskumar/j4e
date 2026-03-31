<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class PurgeUnverifiedUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:purge-unverified';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete users whose email is unverified after 1 day';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $cutoff = now()->subDay();

        $users = User::where('user_type', '!=', 'superadmin')
            ->whereNull('email_verified_at')
            ->where('created_at', '<=', $cutoff)
            ->get();

        if ($users->isEmpty()) {
            $this->info('No unverified users to purge.');
            return Command::SUCCESS;
        }

        $count = 0;
        foreach ($users as $user) {
            $user->forceDelete();
            $count++;
        }

        $this->info("Purged {$count} unverified users.");

        return Command::SUCCESS;
    }
}
