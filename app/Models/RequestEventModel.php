<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequestEventModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'request_events';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'website_url',
        'location_details',
        'venue_details',
        'event_date',
        'city',
        'artist_names',
        'event_details',
        'markas_read',
    ];

    protected $casts = [
        'artist_names' => 'array',
        'event_date' => 'date',
        'markas_read' => 'boolean',
    ];

    public function artistNamesList(): array
    {
        $artists = $this->artist_names;

        return is_array($artists)
            ? array_values(array_filter(array_map('trim', $artists)))
            : [];
    }

    public function artistNamesLabel(): string
    {
        $artists = $this->artistNamesList();

        return $artists ? implode(', ', $artists) : '-';
    }

    public function summaryLabel(): string
    {
        $parts = array_filter([
            $this->venue_details,
            $this->city,
            $this->event_date ? $this->event_date->format('d M Y') : null,
        ]);

        if ($parts) {
            return implode(' · ', $parts);
        }

        return $this->event_details ?: '-';
    }
}
