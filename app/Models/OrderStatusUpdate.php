<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatusUpdate extends Model
{
    use HasFactory;

    protected $table = 'order_status_log';
}
