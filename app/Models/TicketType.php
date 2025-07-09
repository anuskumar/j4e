<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketType extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table ='ticket_type';
    public function eventTickets()
    {
        return $this->hasMany(EventTickets::class, 'ticket_type');
    }
}
