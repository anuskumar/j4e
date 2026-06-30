<?php

namespace App\Http\Controllers;

use App\Models\ArtistModel;
use App\Models\EventType;
use App\Models\Tag;
use App\Models\VenueModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EventsMasterDataController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function storeEventTag(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'tag_name' => 'required|string|max:255',
            'is_active' => 'nullable|in:0,1',
        ]);

        $tag = new Tag();
        $tag->tag_name = $validated['tag_name'];
        $tag->is_active = $request->input('is_active', 1);
        $tag->save();

        return response()->json([
            'success' => true,
            'message' => 'Event tag created successfully.',
            'data' => [
                'id' => $tag->id,
                'text' => $tag->tag_name,
            ],
        ]);
    }

    public function storeEventType(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'is_active' => 'nullable|in:0,1',
        ]);

        $eventType = new EventType();
        $eventType->event_type_name = $validated['name'];
        $eventType->is_active = $request->input('is_active', 1);
        $eventType->save();

        return response()->json([
            'success' => true,
            'message' => 'Event type created successfully.',
            'data' => [
                'id' => $eventType->id,
                'text' => $eventType->event_type_name,
            ],
        ]);
    }

    public function storeVenue(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|exists:location,id',
            'venue_type' => 'required|exists:venue_type,id',
        ]);

        $venue = new VenueModel();
        $venue->venue_type = $validated['venue_type'];
        $venue->name = $validated['name'];
        $venue->location = $validated['location'];
        $venue->save();

        $venueData = VenueModel::leftJoin('location', 'location.id', 'venue.location')
            ->leftJoin('countries', 'countries.id', 'location.country')
            ->leftJoin('cities', 'cities.id', 'location.city')
            ->where('venue.id', $venue->id)
            ->select(
                'venue.id as id',
                'venue.name as venue_name',
                'location_name',
                'cities.name as city_name',
                'country_name'
            )
            ->first();

        $text = sprintf(
            '%s [%s, %s, %s]',
            $venueData->venue_name,
            $venueData->location_name,
            $venueData->city_name,
            $venueData->country_name
        );

        return response()->json([
            'success' => true,
            'message' => 'Venue created successfully.',
            'data' => [
                'id' => $venue->id,
                'text' => $text,
                'label' => $venueData->venue_name . ' — ' . $venueData->location_name . ', ' . $venueData->city_name,
            ],
        ]);
    }

    public function storeArtist(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'artist_name' => 'required|string|max:255',
            'field' => 'required|exists:artist_field,id',
            'contact_number' => 'nullable|string|max:20',
            'about' => 'nullable|string|max:1000',
        ]);

        $artist = new ArtistModel();
        $artist->artist_name = $validated['artist_name'];
        $artist->field = $validated['field'];
        $artist->contact_number = $request->input('contact_number');
        $artist->about = $request->input('about', '');
        $artist->save();

        $artistData = ArtistModel::leftJoin('artist_field', 'artist_field.id', 'artist.field')
            ->where('artist.id', $artist->id)
            ->select('artist.id as id', 'artist_name', 'field_name')
            ->first();

        return response()->json([
            'success' => true,
            'message' => 'Artist created successfully.',
            'data' => [
                'id' => $artistData->id,
                'text' => $artistData->artist_name . ' [' . $artistData->field_name . ']',
            ],
        ]);
    }
}
