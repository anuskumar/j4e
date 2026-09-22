<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventTags extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'event_tags';

    protected $fillable = [
        'tag_name',
        'tag_image',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('tag_name');
    }

    public function resolveHomepageImageUrl(): string
    {
        if (! empty($this->tag_image)) {
            return asset('storage/uploads/event_tag_images/' . $this->tag_image);
        }

        if (! empty($this->event_image)) {
            return asset('storage/uploads/events/' . $this->event_image);
        }

        return asset('assets/img/default-event.jpg');
    }
}
