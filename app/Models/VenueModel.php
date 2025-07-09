<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VenueModel extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'venue';
    public function events()
    {
        return $this->hasMany(Events::class, 'venue');
    }
}
