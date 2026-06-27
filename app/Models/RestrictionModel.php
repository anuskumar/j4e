<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestrictionModel extends Model
{
    use HasFactory;

    protected $table = 'tickets_restrictions';

    protected $fillable = [
        'restrictions',
        'is_active',
    ];
}
