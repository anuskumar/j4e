<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SliderModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'slider';

    protected $fillable = [
        'meta_description',
        'eventid',
        'slide_image',
        'text_color',
        'is_active',
    ];

    public function captionTextColorClass(): string
    {
        return ($this->text_color ?? 'white') === 'black'
            ? 'home-hero__caption--black'
            : 'home-hero__caption--white';
    }
}
