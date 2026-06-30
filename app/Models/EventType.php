<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventType extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'event_type';

    protected $fillable = [
        'event_type_name',
        'is_active',
        'is_header_menu',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_header_menu' => 'boolean',
    ];

    public function scopeHeaderMenu($query)
    {
        return $query->where('is_active', 1)->where('is_header_menu', 1);
    }
}
