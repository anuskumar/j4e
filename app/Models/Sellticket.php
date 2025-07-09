<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Sellticket extends Model
{
    use HasFactory;
    use SoftDeletes;
   protected $table="reseller_tickect_sells";
}
