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

    public const DEFAULT_LOGO = 'logoscroll.png';

    public static function appLogoUrl(): string
    {
        return static::mediaUrl(null, 'company_logo');
    }

    public static function mediaUrl(?self $settings = null, string $field = 'company_logo'): string
    {
        try {
            $settings ??= static::first();
            $file = $settings?->{$field};

            foreach (static::brandImageCandidates($file) as $candidate) {
                if (file_exists($candidate['path'])) {
                    return asset($candidate['url']);
                }
            }

            if (in_array($field, ['company_logo', 'company_logo_small'], true)) {
                if (file_exists(storage_path('uploads/' . self::DEFAULT_LOGO))) {
                    return asset('storage/uploads/' . self::DEFAULT_LOGO);
                }
            }
        } catch (\Throwable $e) {
            // Fall back to the default logo when settings are unavailable.
        }

        return asset('assets/img/logoscroll.png');
    }

    /**
     * @return array<int, array{path: string, url: string}>
     */
    private static function brandImageCandidates(?string $file): array
    {
        if (!$file) {
            return [];
        }

        return [
            [
                'path' => public_path('storage/uploads/images/' . $file),
                'url' => 'storage/uploads/images/' . $file,
            ],
            [
                'path' => storage_path('uploads/images/' . $file),
                'url' => 'storage/uploads/images/' . $file,
            ],
            [
                'path' => storage_path('app/public/uploads/images/' . $file),
                'url' => 'storage/uploads/images/' . $file,
            ],
            [
                'path' => public_path('storage/uploads/' . $file),
                'url' => 'storage/uploads/' . $file,
            ],
            [
                'path' => storage_path('uploads/' . $file),
                'url' => 'storage/uploads/' . $file,
            ],
        ];
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
