<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequestEventModel extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'request_events';
    protected $fillable = [
        'name',
        'email',
        'event_details',
        'phone',
        'markas_read',
    ];

}
