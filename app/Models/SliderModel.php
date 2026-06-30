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

    public const DISPLAY_HEIGHT_DESKTOP = 420;

    public const DISPLAY_HEIGHT_MOBILE = 240;

    public const RECOMMENDED_WIDTH = 1920;

    public const RECOMMENDED_HEIGHT = 420;

    public static function recommendedSizeLabel(): string
    {
        return self::RECOMMENDED_WIDTH . '×' . self::RECOMMENDED_HEIGHT . 'px';
    }

    public static function displaySizeLabel(): string
    {
        return self::RECOMMENDED_WIDTH . '×' . self::DISPLAY_HEIGHT_DESKTOP . 'px (desktop), full width × ' . self::DISPLAY_HEIGHT_MOBILE . 'px (mobile)';
    }

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
