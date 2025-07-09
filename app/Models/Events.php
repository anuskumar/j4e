<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Events extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'event';

    public function eventTickets()
    {
        return $this->hasMany(EventTickets::class, 'event');
    }
    public function venue()
    {
        return $this->belongsTo(VenueModel::class, 'venue');
    }

}

