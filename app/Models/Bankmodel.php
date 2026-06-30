<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bankmodel extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table='event_banks';

    public static function isCompleteForReseller(int $userId): bool
    {
        $bankData = self::where('resellerid', $userId)->first();

        if (!$bankData) {
            return false;
        }

        return filled($bankData->bank_country)
            && filled($bankData->accnt_no)
            && filled($bankData->bic);
    }

}
