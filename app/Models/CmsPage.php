<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CmsPage extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const SLUG_TERMS = 'terms-and-conditions';

    public const SLUG_PRIVACY = 'privacy-policy';

    protected $table = 'cms_pages';

    protected $fillable = [
        'slug',
        'title',
        'content',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public static function findActiveBySlug(string $slug): ?self
    {
        return static::query()
            ->where('slug', $slug)
            ->where('is_active', 1)
            ->first();
    }

    public function publicUrl(): string
    {
        return url($this->slug);
    }
}
