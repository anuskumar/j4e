<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanySettings extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'company_settings';

    public const DEFAULT_LOGO = 'j4elogo.png';

    public static function appLogoUrl(): string
    {
        return static::mediaUrl(null, 'company_logo');
    }

    public static function mediaUrl(?self $settings = null, string $field = 'company_logo'): string
    {
        try {
            $settings ??= static::first();
            $file = $settings?->{$field};

            if ($file && file_exists(public_path('storage/uploads/images/' . $file))) {
                return asset('storage/uploads/images/' . $file);
            }

            if ($field === 'company_logo' || $field === 'company_logo_small') {
                if (file_exists(storage_path('uploads/' . self::DEFAULT_LOGO))) {
                    return asset('storage/uploads/' . self::DEFAULT_LOGO);
                }
            }
        } catch (\Throwable $e) {
            // Fall back to the default logo when settings are unavailable.
        }

        return asset('assets/img/logoscroll.png');
    }

    public static function appLogoPath(): ?string
    {
        try {
            $settings = static::first();

            if ($settings?->company_logo) {
                $path = public_path('storage/uploads/images/' . $settings->company_logo);
                if (file_exists($path)) {
                    return $path;
                }
            }
        } catch (\Throwable $e) {
            // Fall back to the default logo when settings are unavailable.
        }

        $defaultPath = storage_path('uploads/' . self::DEFAULT_LOGO);
        if (file_exists($defaultPath)) {
            return $defaultPath;
        }

        return null;
    }
}
