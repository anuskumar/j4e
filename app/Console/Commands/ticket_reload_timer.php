<?php

namespace App\Console\Commands;

use App\Models\TicketsGenerated;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;

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
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //

        $event_ticket = TicketsGenerated::whereNotNull('under_purchase_hold')->get();

        foreach ($event_ticket as $key) {


            $givenTime = Carbon::parse($key->purchase_hold_time);
            $currentTime = Carbon::now();
            $minutesDifference = $givenTime->diffInMinutes($currentTime);

            if($minutesDifference>15){

                $dat = TicketsGenerated::find($key->id);
                $dat->user_id = NULL;
                $dat->under_purchase_hold = 0;
                $dat->purchase_hold_time = NULL;
                $dat->save();
            }
        }

    }
}
