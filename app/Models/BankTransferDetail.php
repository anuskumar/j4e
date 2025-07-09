<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankTransferDetail extends Model
{
    use HasFactory;
    protected $table = 'bank_transfer_details';

    protected $fillable = [
        'reseller_id',
        'currency_id',
        'bank_name',
        'account_holder_name',
        'account_number',
        'routing_number',
        'additional_notes',
    ];

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id', 'id');
    }
}
