<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OutsideSellModel extends Model
{

    use HasFactory;
    use SoftDeletes;
    protected $table="outsidesell";
    protected $fillable=['name','phone','address','date','payment_mode'];

    public function ticketsGenerated()
    {
        return $this->belongsTo(TicketsGenerated::class, 'event_ticket_tickets_id', 'id');
    }
}
