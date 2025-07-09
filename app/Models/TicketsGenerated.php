<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketsGenerated extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'event_ticket_tickets';

    public static function get_the_number_of_tickets($id){

        $data = TicketsGenerated::where('event_tickets',$id)->where('is_sold',0)->where('under_purchase_hold',0)->get();
        return $data;
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
