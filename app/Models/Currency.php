<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Currency extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'currency';

    protected $fillable = [
        'name',
        'short_name',
        'symbol',
        'currency_rate',
        'rate_updated_at',
        'is_active',
    ];

    protected $casts = [
        'currency_rate' => 'float',
        'is_active' => 'integer',
        'rate_updated_at' => 'datetime',
    ];
}
