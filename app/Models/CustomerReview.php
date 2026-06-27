<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerReview extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'customer_reviews';

    protected $fillable = [
        'customer_name',
        'subtitle',
        'rating',
        'review_content',
        'customer_photo',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'rating' => 'float',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function photoUrl(): string
    {
        if ($this->customer_photo) {
            return asset('storage/uploads/customer_reviews/' . $this->customer_photo);
        }

        return asset('assets/img/testimonial/avatar-01.jpg');
    }
}
