<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventTiming extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'event_timings';

    public static function get_events_with_date($event,$date){

        return EventTiming::where('event',$event)->where('is_active',1)->where('event_date',$date)->get();
    }

    public static function get_ticket_list($event,$timing_id){

        return EventTickets::leftjoin('ticket_type','ticket_type.id','event_tickets.ticket_type')->
        leftjoin('venue_seating','venue_seating.id','event_tickets.venue_seating')
        ->leftjoin('currency','currency.id','event_tickets.amount_currency')->
        where('event',$event)->where('event_timing',$timing_id)->where('event_tickets.is_admin_approved', 1)->select('*','event_tickets.id as id')->orderBy('event_tickets.web_price', 'asc')->get();
    }

    public static function get_available_tickets($ticket_id){

        $data =  TicketsGenerated::leftjoin('event_tickets','event_tickets.id','=','event_ticket_tickets.event_tickets')
        ->where('event_ticket_tickets.event_tickets',$ticket_id)
        ->where('event_ticket_tickets.is_sold',0)
        ->where('event_ticket_tickets.under_purchase_hold',0)
        ->where('event_ticket_tickets.on_sale',1)
        ->where('event_tickets.is_admin_approved',1)
        ->count();

        return $data;
    }

    public function ticketsGenerated()
    {
        return $this->hasMany(TicketsGenerated::class, 'event_timing');
    }



}
