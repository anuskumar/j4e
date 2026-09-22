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
        'description_position',
        'show_button',
        'button_text',
        'button_color',
        'button_size',
        'button_position',
        'is_active',
    ];

    public const DESCRIPTION_POSITIONS = [
        'left-top' => 'Left Top',
        'left-center' => 'Left Center',
        'left-bottom' => 'Left Bottom',
        'center-top' => 'Center Top',
        'center-center' => 'Center Center',
        'center-bottom' => 'Center Bottom',
        'right-top' => 'Right Top',
        'right-center' => 'Right Center',
        'right-bottom' => 'Right Bottom',
    ];

    public const BUTTON_SIZES = [
        'small' => 'Small',
        'medium' => 'Medium',
        'large' => 'Large',
    ];

    public function captionTextColorClass(): string
    {
        return ($this->text_color ?? 'white') === 'black'
            ? 'home-hero__caption--black'
            : 'home-hero__caption--white';
    }

    public function captionPositionClass(): string
    {
        $position = $this->description_position ?? 'left-center';

        if (! array_key_exists($position, self::DESCRIPTION_POSITIONS)) {
            $position = 'left-center';
        }

        return 'home-hero__overlay--' . $position;
    }

    public function descriptionPositionLabel(): string
    {
        $position = $this->description_position ?? 'left-center';

        return self::DESCRIPTION_POSITIONS[$position] ?? self::DESCRIPTION_POSITIONS['left-center'];
    }

    public function shouldShowButton(): bool
    {
        return (int) ($this->show_button ?? 0) === 1 && ! empty($this->eventid);
    }

    public function buttonLabel(): string
    {
        $text = trim((string) ($this->button_text ?? ''));

        return $text !== '' ? $text : 'Book Now';
    }

    public function buttonColorValue(): string
    {
        $color = trim((string) ($this->button_color ?? ''));

        if ($color !== '' && preg_match('/^#([A-Fa-f0-9]{3}|[A-Fa-f0-9]{6})$/', $color)) {
            return $color;
        }

        return '#671dcf';
    }

    public function buttonSizeClass(): string
    {
        $size = $this->button_size ?? 'medium';

        if (! array_key_exists($size, self::BUTTON_SIZES)) {
            $size = 'medium';
        }

        return 'home-hero__btn--' . $size;
    }

    public function buttonPositionClass(): string
    {
        $position = $this->button_position ?? 'right-bottom';

        if (! array_key_exists($position, self::DESCRIPTION_POSITIONS)) {
            $position = 'right-bottom';
        }

        return 'home-hero__btn-pos--' . $position;
    }

    public function buttonPositionLabel(): string
    {
        $position = $this->button_position ?? 'right-bottom';

        return self::DESCRIPTION_POSITIONS[$position] ?? self::DESCRIPTION_POSITIONS['right-bottom'];
    }

    public function buttonSizeLabel(): string
    {
        $size = $this->button_size ?? 'medium';

        return self::BUTTON_SIZES[$size] ?? self::BUTTON_SIZES['medium'];
    }
}
