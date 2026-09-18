<?php

namespace App\Http\Controllers;

use App\Models\CityModel;
use App\Models\CountryModel;
use App\Models\LocationModel;
use App\Models\VenueModel;
use App\Models\VenueSeating;
use App\Models\VenueType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class VenueController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = VenueModel::leftjoin('venue_type', 'venue_type.id', 'venue.venue_type')
            ->leftjoin('location', 'location.id', 'venue.location')
            ->leftjoin('countries', 'countries.id', 'location.country')
            ->leftjoin('cities', 'cities.id', 'location.city')
            ->select(
                'venue.*',
                'venue.id as id',
                'venue.name as venue_name',
                'venue_type.venue_type_name',
                'cities.name as city_name',
                'countries.country_name'
            )
            ->orderBy('venue.id', 'desc')
            ->get();

        foreach ($data as $val) {
            $val['total_seats'] = VenueSeating::where('venue', $val->id)->sum('number_of_seats');
            $val['total_seat_types'] = VenueSeating::where('venue', $val->id)->count();
        }

        return view('admin.venue.list', compact('data'));
    }

    public function manage_Seating($id)
    {
        $venue = VenueModel::findOrFail($id);
        $data = VenueSeating::where('venue', $id)->orderBy('id', 'desc')->get();

        return view('admin.venue.manage_seating', compact('data', 'venue'));
    }

    public function create_seating($venueId)
    {
        $venue = VenueModel::findOrFail($venueId);

        return view('admin.venue.create_seating', compact('venue'));
    }

    public function view_seating($id)
    {
        $data = VenueSeating::findOrFail($id);
        $venue = VenueModel::findOrFail($data->venue);

        return view('admin.venue.view_seating', compact('data', 'venue'));
    }

    public function create()
    {
        $venue_type = VenueType::get();
        $countries = CountryModel::orderBy('country_name')->get();
        $selectedCountryId = old('country_id');
        $cities = $selectedCountryId
            ? CityModel::where('country_id', $selectedCountryId)->orderBy('name')->get()
            : collect();

        return view('admin.venue.create', compact('venue_type', 'countries', 'cities'));
    }

    public function show(string $id)
    {
        $data = VenueModel::leftjoin('venue_type', 'venue_type.id', 'venue.venue_type')
            ->leftjoin('location', 'location.id', 'venue.location')
            ->leftjoin('countries', 'countries.id', 'location.country')
            ->leftjoin('cities', 'cities.id', 'location.city')
            ->select('*', 'venue.id as id', 'venue.name as venue_name')
            ->find($id);

        return view('admin.venue.view', compact('data'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'country_id' => 'required|exists:countries,id',
            'city_id' => [
                'required',
                Rule::exists('cities', 'id')->where(fn ($query) => $query->where('country_id', $request->country_id)),
            ],
            'venue_type' => 'required|exists:venue_type,id',
        ]);

        $venue = new VenueModel();
        $venue->venue_type = $request->venue_type;
        $venue->name = $request->name;
        $venue->location = $this->resolveLocationId((int) $validated['country_id'], (int) $validated['city_id']);
        $venue->google_map_link = $request->google_map_link;
        $venue->latitude = $request->latitude;
        $venue->longitude = $request->longitude;

        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(storage_path('uploads/venue'), $imageName);
            $venue->image = $imageName;
        }

        $venue->save();

        return redirect('venue/list')->with('success', 'Venue created successfully.');
    }

    public function edit(string $id)
    {
        $data = VenueModel::findOrFail($id);
        $venue_type = VenueType::get();
        $countries = CountryModel::orderBy('country_name')->get();

        $location = LocationModel::find($data->location);
        $selectedCountryId = old('country_id', $location->country ?? null);
        $selectedCityId = old('city_id', $location->city ?? null);
        $cities = $selectedCountryId
            ? CityModel::where('country_id', $selectedCountryId)->orderBy('name')->get()
            : collect();

        return view('admin.venue.edit', compact(
            'venue_type',
            'countries',
            'cities',
            'data',
            'selectedCountryId',
            'selectedCityId'
        ));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:venue,id',
            'name' => 'required|string|max:255',
            'venue_type' => 'required|exists:venue_type,id',
            'country_id' => 'required|exists:countries,id',
            'city_id' => [
                'required',
                Rule::exists('cities', 'id')->where(fn ($query) => $query->where('country_id', $request->country_id)),
            ],
        ]);

        $data = VenueModel::findOrFail($request->id);
        $data->venue_type = $request->venue_type;
        $data->name = $request->name;
        $data->location = $this->resolveLocationId((int) $validated['country_id'], (int) $validated['city_id']);
        $data->google_map_link = $request->google_map_link;
        $data->latitude = $request->latitude;
        $data->longitude = $request->longitude;

        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(storage_path('uploads/venue'), $imageName);
            $data->image = $imageName;
        }

        $data->save();

        return redirect('venue/list')->with('success', 'Venue updated successfully.');
    }

    public function delete($id)
    {
        $data = VenueModel::find($id);
        $data->delete();

        return redirect('/venue/list');
    }

    public function store_seating(Request $request)
    {
        $validated = $request->validate([
            'venue' => 'required',
            'seating_type_name' => 'required',
            'number_of_seats' => 'nullable|integer|min:0',
        ]);

        $data = new VenueSeating();
        $data->venue = $request->venue;
        $data->seating_type_name = $request->seating_type_name;
        $data->number_of_seats = $request->filled('number_of_seats') ? (int) $request->number_of_seats : null;
        $data->seat_serial_prefix = null;
        $data->seat_serial_start = null;
        $data->seat_serial_end = null;
        $data->seating_type_desc = $request->seating_type_desc;
        $data->is_active = $request->is_active;

        if ($request->hasFile('seating_image')) {
            $imageName = time().'.'.$request->seating_image->extension();
            $request->seating_image->move(storage_path('uploads/venue_seating'), $imageName);
            $data->seating_image = $imageName;
        }

        $data->save();

        return redirect('venue/manage_Seating/'.$request->venue)->with('success', 'Seating created successfully.');
    }

    public function edit_seating(string $id)
    {
        $data = VenueSeating::findOrFail($id);
        $venue = VenueModel::findOrFail($data->venue);

        return view('admin.venue.edit_seating', compact('data', 'venue'));
    }

    public function update_Seating(Request $request)
    {
        $validated = $request->validate([
            'seating_type_name' => 'required',
            'number_of_seats' => 'nullable|integer|min:0',
        ]);

        $data = VenueSeating::find($request->id);
        $data->id = $request->id;
        $data->seating_type_name = $request->seating_type_name;
        $data->number_of_seats = $request->filled('number_of_seats') ? (int) $request->number_of_seats : null;
        $data->seat_serial_prefix = null;
        $data->seat_serial_start = null;
        $data->seat_serial_end = null;
        $data->seating_type_desc = $request->seating_type_desc;
        $data->is_active = $request->is_active;

        if ($request->hasFile('seating_image')) {
            $imageName = time().'.'.$request->seating_image->extension();
            $request->seating_image->move(storage_path('uploads/venue_seating'), $imageName);
            $data->seating_image = $imageName;
        }

        $data->save();

        return redirect('venue/manage_Seating/'.$data->venue)->with('success', 'Seating updated successfully.');
    }

    public function delete_seating($id)
    {
        $data = VenueSeating::find($id);
        $data->delete();

        return redirect()->back()->with('success', 'Updated Successfully');
    }

    public function getCity($countryId)
    {
        $cities = CityModel::where('country_id', $countryId)
            ->orderBy('name')
            ->pluck('name', 'id');

        return response()->json($cities);
    }

    /**
     * Keep venue.location FK compatibility by resolving/creating a location for country + city.
     */
    private function resolveLocationId(int $countryId, int $cityId): int
    {
        $city = CityModel::where('id', $cityId)
            ->where('country_id', $countryId)
            ->firstOrFail();

        $location = LocationModel::withTrashed()
            ->where('country', $countryId)
            ->where('city', $cityId)
            ->first();

        if ($location) {
            if ($location->trashed()) {
                $location->restore();
            }

            if (empty($location->location_name)) {
                $location->location_name = $city->name;
                $location->is_active = 1;
                $location->save();
            }

            return (int) $location->id;
        }

        $location = new LocationModel();
        $location->location_name = $city->name;
        $location->country = $countryId;
        $location->city = $cityId;
        $location->is_active = 1;
        $location->save();

        return (int) $location->id;
    }
}
