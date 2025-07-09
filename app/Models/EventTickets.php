<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventTickets extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'event_tickets';
    protected $fillable = [
        'ticket_upload',
        'unique_id',
        'ticket_name',
        'ticket_type',
        'mobile_application_id',
        'event',
        'event_timing',
        'row',
        'seat_from',
        'seat_to',
        'no_of_tickets',
        'cover_image',
        'venue_seating',
        'ticket_amount',
        'face_value',
        'ticket_restrictions',
        'features',
        'amount_currency',
        'face_value_currency',
        'booking_expiry_date_time',
        'disclaimer_note',
        'cancellation_policy_notes',
        'map_layout',
        'is_admin_approved',
        'ticket_status',
        'split_type',
        'web_price',
        'seller_fee',
        'recive_perticket',
        'total_recive',
        'proof_of_id',
        'proof_of_purchase',
        'created_by',
    ];

    public function ticketType()
    {
        return $this->belongsTo(TicketType::class, 'ticket_type');
    }

    public function eventTicketTickets()
    {
        return $this->hasMany(TicketsGenerated::class, 'event_tickets');
    }

    public function event()
    {
        return $this->belongsTo(Events::class, 'event');
    }
}
