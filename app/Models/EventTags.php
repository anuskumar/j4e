<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventTags extends Model
{
    use HasFactory;

    protected $table = 'event_tags';

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
