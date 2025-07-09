<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SelectedPaymentMethod extends Model
{
    use HasFactory;
    protected $table = 'selected_payment_methods';
    protected $fillable = ['reseller_id', 'payment_type', 'payment_id'];
}
