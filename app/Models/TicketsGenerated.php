<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketsGenerated extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'event_ticket_tickets';

    protected $fillable = ['seat_id', 'file', 'ticket_amount'];

    public static function get_the_number_of_tickets($id){

        $data = TicketsGenerated::where('event_tickets',$id)->where('is_sold',0)->where('under_purchase_hold',0)->get();
        return $data;
    }

    /**
     * Release checkout holds that have exceeded the 15-minute window.
     */
    public static function releaseExpiredHolds(?int $eventTicketId = null): int
    {
        $validHoldStart = Carbon::now()->subMinutes(15);

        $query = self::where('under_purchase_hold', 1)
            ->where('is_sold', 0)
            ->where(function ($q) use ($validHoldStart) {
                $q->whereNull('purchase_hold_time')
                    ->orWhere('purchase_hold_time', '<', $validHoldStart);
            });

        if ($eventTicketId !== null) {
            $query->where('event_tickets', $eventTicketId);
        }

        return $query->update([
            'user_id' => null,
            'under_purchase_hold' => 0,
            'purchase_hold_time' => null,
        ]);
    }

    public function eventTicket()
    {
        return $this->belongsTo(EventTickets::class, 'event_tickets');
    }

    public function eventTiming()
    {
        return $this->belongsTo(EventTiming::class, 'event_timing');
    }
    public function outsideSell()
    {
        return $this->hasOne(OutsideSellModel::class, 'event_ticket_tickets_id', 'id');
    }
}
