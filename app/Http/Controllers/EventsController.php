<?php

namespace App\Http\Controllers;

use App\Models\ArtistField;
use App\Models\ArtistModel;
use App\Models\EventImages;
use App\Models\Events;
use App\Models\EventTags;
use App\Models\EventTiming;
use App\Models\EventType;
use App\Models\LocationModel;
use App\Models\RequestEventModel;
use App\Models\TicketType;
use App\Models\VenueModel;
use App\Models\VenueType;
use App\Services\NotificationService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class EventsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $query = Events::query()
            ->leftJoin('event_type', 'event_type.id', 'event.event_type')
            ->leftJoin('users', 'users.id', 'event.event_added_by')
            ->leftJoin('venue', 'venue.id', 'event.venue')
            ->leftJoin('location', 'location.id', 'venue.location')
            ->leftJoin('countries', 'countries.id', 'location.country')
            ->leftJoin('cities', 'cities.id', 'location.city')
            ->select(
                'event.*',
                'event.id as id',
                'event_type.event_type_name',
                'country_name',
                'cities.name as city_name',
                'location_name',
                'location.id as location_id',
                'venue.id as venue_id',
                'venue.name as venue_name'
            )
            ->orderByDesc('event.id');

        if ($request->filled('event_type')) {
            $query->where('event.event_type', $request->event_type);
        }

        if ($request->filled('location_id')) {
            $query->where('location.id', $request->location_id);
        }

        if ($request->filled('venue_id')) {
            $query->where('venue.id', $request->venue_id);
        }

        if ($request->filled('event_date_from')) {
            $query->whereDate('event.event_from_date', '>=', $request->event_date_from);
        }

        if ($request->filled('event_date_to')) {
            $query->where(function ($dateQuery) use ($request) {
                $dateQuery->whereDate('event.event_to_date', '<=', $request->event_date_to)
                    ->orWhere(function ($fallback) use ($request) {
                        $fallback->whereNull('event.event_to_date')
                            ->whereDate('event.event_from_date', '<=', $request->event_date_to);
                    });
            });
        }

        $data = $query->get();

        $eventTypes = EventType::orderBy('event_type_name')->get();

        $locations = LocationModel::leftJoin('countries', 'countries.id', 'location.country')
            ->leftJoin('cities', 'cities.id', 'location.city')
            ->select('location.id', 'location_name', 'cities.name as city_name', 'country_name')
            ->orderBy('location_name')
            ->get();

        $venuesQuery = VenueModel::leftJoin('location', 'location.id', 'venue.location')
            ->leftJoin('countries', 'countries.id', 'location.country')
            ->leftJoin('cities', 'cities.id', 'location.city')
            ->select('venue.id', 'venue.name as venue_name', 'location_name', 'cities.name as city_name', 'country_name', 'venue.location as location_id');

        if ($request->filled('location_id')) {
            $venuesQuery->where('venue.location', $request->location_id);
        }

        $venues = $venuesQuery->orderBy('venue.name')->get();

        $filters = [
            'event_type' => $request->event_type,
            'location_id' => $request->location_id,
            'venue_id' => $request->venue_id,
            'event_date_from' => $request->event_date_from,
            'event_date_to' => $request->event_date_to,
        ];

        return view('admin.events.list', compact('data', 'eventTypes', 'locations', 'venues', 'filters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    $event_type = EventType::get();
    $venue = VenueModel::
     leftjoin('location','location.id','venue.location')
    ->leftjoin('countries','countries.id','location.country')
    ->leftjoin('cities','cities.id','location.city')
    ->select('venue.id as id','country_name','cities.name as city_name','location_name','venue.name as venue_name')
    ->get();
    $artists = ArtistModel::leftjoin('artist_field','artist_field.id','artist.field')->select('*','artist.id as id')->get();
    $eventTags = EventTags::where('is_active',1)->get();
    $ticketTypes = TicketType::where('is_active', 1)->get();
    $venueTypes = VenueType::orderBy('venue_type_name')->get();
    $locations = LocationModel::leftJoin('countries', 'countries.id', 'location.country')
        ->leftJoin('cities', 'cities.id', 'location.city')
        ->select('location.id', 'location_name', 'cities.name as city_name', 'country_name')
        ->orderBy('location_name')
        ->get();
    $artistFields = ArtistField::orderBy('field_name')->get();

    return view('admin.events.create', compact(
        'event_type',
        'venue',
        'artists',
        'eventTags',
        'ticketTypes',
        'venueTypes',
        'locations',
        'artistFields'
    ));

     }
     public function show($id)
    {
        $data = Events::leftjoin('event_type', 'event_type.id', 'event.event_type')
            ->leftjoin('event_tags', 'event_tags.id', 'event.event_tag')
            ->leftjoin('users', 'users.id', 'event.event_added_by')
            ->leftjoin('venue', 'venue.id', 'event.venue')
            ->leftjoin('location', 'location.id', 'venue.location')
            ->leftjoin('countries', 'countries.id', 'location.country')
            ->leftjoin('cities', 'cities.id', 'location.city')
            ->select(
                'event.*',
                'event.id as id',
                'event_type.event_type_name',
                'event_tags.tag_name as event_tag_name',
                'country_name',
                'cities.name as city_name',
                'location_name',
                'venue.name as venue_name'
            )
            ->findOrFail($id);

        $eventTiming = EventTiming::where('event', $id)->where('is_active', 1)->orderBy('id')->first();

        $selectedArtistIds = $data->artists ? json_decode($data->artists, true) : [];
        $selectedTicketTypeIds = $data->ticket_types ? json_decode($data->ticket_types, true) : [];

        $artistNames = $selectedArtistIds
            ? ArtistModel::leftjoin('artist_field', 'artist_field.id', 'artist.field')
                ->whereIn('artist.id', $selectedArtistIds)
                ->get()
                ->map(fn ($artist) => $artist->artist_name . ' [' . $artist->field_name . ']')
                ->implode(', ')
            : '';

        $ticketTypeNames = $selectedTicketTypeIds
            ? TicketType::whereIn('id', $selectedTicketTypeIds)->pluck('ticket_type_name')->implode(', ')
            : '';

        return view('admin.events.view', compact('data', 'eventTiming', 'artistNames', 'ticketTypeNames'));
     }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $existingTempImage = $request->input('temp_event_image');

        $validator = Validator::make($request->all(), [
            'event_name' => 'required',
            'event_is_active' => 'required',
            'event_tag' => 'required',
            'event_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'temp_event_image' => 'nullable|string',
            'seller_fee_percent' => 'required|numeric|min:0|max:100',
            'customer_fee_percent' => 'required|numeric|min:0|max:100',
            'priority' => 'required|integer|min:0|max:9999',
            'event_from_date' => 'required|date',
            'event_to_date' => 'required|date|after_or_equal:event_from_date',
            'event_start_time' => 'required|date_format:H:i',
            'event_end_time' => 'required|date_format:H:i',
        ]);

        $validator->after(function ($validator) use ($request, $existingTempImage) {
            if (!$request->hasFile('event_image') && !$this->isValidTempEventImageFilename($existingTempImage)) {
                $validator->errors()->add('event_image', 'Please upload an event image.');
            }

            $fields = ['event_from_date', 'event_to_date', 'event_start_time', 'event_end_time'];
            foreach ($fields as $field) {
                if ($validator->errors()->has($field)) {
                    return;
                }
            }

            $start = Carbon::parse($request->event_from_date . ' ' . $request->event_start_time);
            $end = Carbon::parse($request->event_to_date . ' ' . $request->event_end_time);

            if (!$end->gt($start)) {
                $validator->errors()->add(
                    'event_end_time',
                    'The event end date and time must be after the event start date and time.'
                );
            }
        });

        if ($validator->fails()) {
            $this->preserveEventImageOnValidationFailure($request, $existingTempImage);

            return redirect()->back()->withErrors($validator)->withInput();
        }

        $event = new Events();
        $event->event_name = $request->event_name;
        $event->event_type = $request->event_type;
        $event->venue = $request->venue;
        if(!$request->artists==null){

            $event->artists = json_encode($request->artists);

            }
        if(!$request->ticket_types==null){

            $event->ticket_types = json_encode($request->ticket_types);

            }

        $event->event_from_date = $request->event_from_date;
        $event->event_tag = $request->event_tag;
        $event->seller_fee_percent = $request->seller_fee_percent;
        $event->customer_fee_percent = $request->customer_fee_percent;
        $event->priority = $request->priority ?? 0;
        $event->event_to_date = $request->event_to_date;
        $event->event_desc = $request->event_desc;
        $event->event_added_by =Auth::user()->id;
        $event->event_image = $this->resolveEventImageForStore($request, $existingTempImage);
        $event->event_is_active = $request->event_is_active;

        $event->save();

        $timing = new EventTiming();
        $timing->event = $event->id;
        $timing->event_date = $request->event_from_date;
        $timing->from_time = $request->event_start_time;
        $timing->to_time = $request->event_end_time;
        $timing->is_active = 1;
        $timing->save();

        app(NotificationService::class)->notifyEventCreated($event);

        return redirect('events/list');
     }

     public function edit(string $id)
     {
        $event_type = EventType::get();
        $data = Events::findOrFail($id);
        $venue = VenueModel::leftjoin('location', 'location.id', 'venue.location')
            ->leftjoin('countries', 'countries.id', 'location.country')
            ->leftjoin('cities', 'cities.id', 'location.city')
            ->select('venue.id as id', 'country_name', 'cities.name as city_name', 'location_name', 'venue.name as venue_name')
            ->get();
        $artists = ArtistModel::leftjoin('artist_field', 'artist_field.id', 'artist.field')->select('*', 'artist.id as id')->get();
        $eventTags = EventTags::where('is_active', 1)->get();
        $ticketTypes = TicketType::where('is_active', 1)->get();
        $venueTypes = VenueType::orderBy('venue_type_name')->get();
        $locations = LocationModel::leftJoin('countries', 'countries.id', 'location.country')
            ->leftJoin('cities', 'cities.id', 'location.city')
            ->select('location.id', 'location_name', 'cities.name as city_name', 'country_name')
            ->orderBy('location_name')
            ->get();
        $artistFields = ArtistField::orderBy('field_name')->get();
        $eventTiming = EventTiming::where('event', $id)->where('is_active', 1)->orderBy('id')->first();

        return view('admin.events.edit', compact(
            'data',
            'event_type',
            'artists',
            'venue',
            'eventTags',
            'ticketTypes',
            'venueTypes',
            'locations',
            'artistFields',
            'eventTiming'
        ));
     }
     public function update(Request $request){

        $data = Events::findOrFail($request->id);

        $validator = Validator::make($request->all(), [
            'event_name' => 'required',
            'event_tag' => 'required',
            'event_image' => [
                Rule::requiredIf(fn () => empty($data->event_image)),
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,webp',
                'max:5120',
            ],
            'seller_fee_percent' => 'required|numeric|min:0|max:100',
            'customer_fee_percent' => 'required|numeric|min:0|max:100',
            'priority' => 'required|integer|min:0|max:9999',
            'event_from_date' => 'required|date',
            'event_to_date' => 'required|date|after_or_equal:event_from_date',
            'event_start_time' => 'required|date_format:H:i',
            'event_end_time' => 'required|date_format:H:i',
        ]);

        $validator->after(function ($validator) use ($request) {
            $fields = ['event_from_date', 'event_to_date', 'event_start_time', 'event_end_time'];
            foreach ($fields as $field) {
                if ($validator->errors()->has($field)) {
                    return;
                }
            }

            $start = Carbon::parse($request->event_from_date . ' ' . $request->event_start_time);
            $end = Carbon::parse($request->event_to_date . ' ' . $request->event_end_time);

            if (!$end->gt($start)) {
                $validator->errors()->add(
                    'event_end_time',
                    'The event end date and time must be after the event start date and time.'
                );
            }
        });

        $validator->validate();

        $data->event_name = $request->event_name;
        $data->event_type = $request->event_type;
        $data->event_desc = $request->event_desc;
        $data->venue = $request->venue;

        if(!$request->artists==null){

        $data->artists = json_encode($request->artists);

        } else {
            $data->artists = null;
        }
        
        if(!$request->ticket_types==null){

        $data->ticket_types = json_encode($request->ticket_types);

        } else {
            $data->ticket_types = null;
        }
        
        $data->event_from_date = $request->event_from_date;
        $data->event_to_date = $request->event_to_date;
        $data->event_tag = $request->event_tag;
        $data->seller_fee_percent = $request->seller_fee_percent;
        $data->customer_fee_percent = $request->customer_fee_percent;
        $data->priority = $request->priority ?? 0;
        $data->event_is_active = $request->event_is_active;

        if($request->hasFile('event_image')){
            $imageName = time().'.'.$request->event_image->extension();
            $request->event_image->move(storage_path('uploads/events'), $imageName);
            $data->event_image =  $imageName;
        }

        $data->save();

        $timing = EventTiming::where('event', $data->id)->where('is_active', 1)->orderBy('id')->first();
        if ($timing) {
            $timing->event_date = $request->event_from_date;
            $timing->from_time = $request->event_start_time;
            $timing->to_time = $request->event_end_time;
            $timing->save();
        } else {
            $timing = new EventTiming();
            $timing->event = $data->id;
            $timing->event_date = $request->event_from_date;
            $timing->from_time = $request->event_start_time;
            $timing->to_time = $request->event_end_time;
            $timing->is_active = 1;
            $timing->save();
        }

        return redirect('events/list');
     }
     public function delete( $id)
    {
        $data=Events::find($id);
        $data->delete();
        return redirect('/events/list');

    }


    public function multi_images($id){

        $event = Events::findOrFail($id);
        $data = EventImages::where('event', $id)->orderBy('id', 'desc')->get();
        return view('admin.events.event_images', compact('data', 'id', 'event'));

    }

    public function upload_event_images(Request $request)
    {
        $uploadErrors = $this->collectUploadErrors($request);
        if ($uploadErrors !== []) {
            return redirect()->back()->withErrors(['image' => implode(' ', $uploadErrors)]);
        }

        $request->validate([
            'event' => 'required|integer|exists:event,id',
            'image' => 'required|array|min:1',
            'image.*' => 'required|file|image|mimes:jpeg,png,jpg,webp,gif|max:2048',
        ], [
            'image.required' => 'Please select at least one image to upload.',
            'image.*.max' => 'Each image must not be larger than 2MB.',
            'image.*.image' => 'Only valid image files are allowed.',
        ]);

        $uploadDir = storage_path('uploads/events');
        if (! is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        if (! is_writable($uploadDir)) {
            return redirect()->back()->withErrors([
                'image' => 'Upload folder is not writable. Please contact the administrator.',
            ]);
        }

        $uploadedCount = 0;

        foreach ($request->file('image') as $file) {
            if (! $file || ! $file->isValid()) {
                continue;
            }

            try {
                $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                $file->move($uploadDir, $filename);

                $val = new EventImages();
                $val->event = $request->event;
                $val->image = $filename;
                $val->save();
                $uploadedCount++;
            } catch (\Throwable $exception) {
                report($exception);

                return redirect()->back()->withErrors([
                    'image' => 'Upload failed while saving the image. Please try again.',
                ]);
            }
        }

        if ($uploadedCount === 0) {
            return redirect()->back()->withErrors([
                'image' => 'No valid images were uploaded. Use JPG, PNG, WEBP or GIF under 2MB.',
            ]);
        }

        return redirect()->back()->with('success', $uploadedCount . ' image(s) uploaded successfully.');
    }

    private function collectUploadErrors(Request $request): array
    {
        $messages = [];

        if (! empty($_FILES['image']['error'])) {
            $errors = (array) $_FILES['image']['error'];

            foreach ($errors as $error) {
                if ($error === UPLOAD_ERR_INI_SIZE || $error === UPLOAD_ERR_FORM_SIZE) {
                    $messages[] = 'One or more images exceed the 2MB upload limit.';
                } elseif ($error !== UPLOAD_ERR_OK && $error !== UPLOAD_ERR_NO_FILE) {
                    $messages[] = 'One or more images could not be uploaded.';
                }
            }
        }

        if ($messages === [] && ! $request->hasFile('image')) {
            $contentLength = (int) $request->server('CONTENT_LENGTH', 0);
            if ($contentLength > 0 && empty($request->all()) && empty($_FILES)) {
                $messages[] = 'Upload failed. The selected files may exceed the server upload limit.';
            }
        }

        return array_values(array_unique($messages));
    }

    public function event_timings($id){

        $data = EventTiming::where('event',$id)->get();
        return view('admin.events.event_timings',compact('data','id'));

    }

    public function store_timings(Request $request){

        // dd($request->request);

        $val =new EventTiming();
        $val->event = $request->event;
        $val->event_date = $request->event_date;
        $val->from_time = $request->from_time;
        $val->to_time = $request->to_time;
        $val->is_active = $request->is_active;
        $val->save();

        return  back();

    }
    public function delete_multiimages( $id)
    {
        $data=EventImages::find($id);
        $data->delete();
        return redirect()->back()->with('success','Deleted Successfully');

    }

    public function edit_timings(string $id)
     {
        $data = EventTiming::find($id);

        return view('admin.events.edit_eventtimings',compact('data','id'));

     }

     public function update_timings(Request $request){

        // dd($request->request);
        $validated = $request->validate([

                        'event_date' => 'required',
                        'from_time' => 'required',

        ]);

       $data=EventTiming::find($request->id);
       $data->id=$request->id;
       $data->event_date=$request->event_date;
       $data->from_time=$request->from_time;
       $data->to_time=$request->to_time;

       $data->is_active = $request->is_active;
    //    $data->image = $request->image;


       $data->save();



    return redirect('events/event_timings'.'/'.$data->event);
    //  return redirect()->back();

   }
   public function delete_timings( $id)
    {
        $data=EventTiming::find($id);
        $data->delete();
        return redirect('/events/event_timings'.'/'.$data->event);

    }

    public function requestlist(){
        // dd('hai');
        $records = RequestEventModel::where('markas_read', '0')->get();
        foreach ($records as $record) {
            $record->update(['markas_read' => '1']);
        }

        $data=RequestEventModel::get();
        // dd($data);
        return view('admin.events.requestevent_list',compact('data'));
    }

    public function filterEvents($locationId)
{
    $events = Events::where('location_id', $locationId)->get();
    return response()->json($events);
}

    private function isValidTempEventImageFilename(?string $filename): bool
    {
        if ($filename === null || $filename === '') {
            return false;
        }

        return (bool) preg_match('/^temp_[a-f0-9\-]+\.(jpe?g|png|webp)$/i', $filename);
    }

    private function tempEventImagePath(string $filename): string
    {
        return storage_path('uploads/events/temp/' . $filename);
    }

    private function deleteTempEventImage(?string $filename): void
    {
        if (!$this->isValidTempEventImageFilename($filename)) {
            return;
        }

        $path = $this->tempEventImagePath($filename);
        if (is_file($path)) {
            unlink($path);
        }
    }

    private function preserveEventImageOnValidationFailure(Request $request, ?string $existingTempImage): void
    {
        if (!$request->hasFile('event_image')) {
            if ($this->isValidTempEventImageFilename($existingTempImage)) {
                session()->flash('temp_event_image', $existingTempImage);
            }

            return;
        }

        $tempDir = storage_path('uploads/events/temp');
        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0755, true);
        }

        $this->deleteTempEventImage($existingTempImage);

        $imageName = 'temp_' . Str::uuid() . '.' . $request->file('event_image')->extension();
        $request->file('event_image')->move($tempDir, $imageName);
        session()->flash('temp_event_image', $imageName);
    }

    private function resolveEventImageForStore(Request $request, ?string $existingTempImage): string
    {
        $uploadDir = storage_path('uploads/events');
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        if ($request->hasFile('event_image')) {
            $this->deleteTempEventImage($existingTempImage);
            $imageName = time() . '.' . $request->file('event_image')->extension();
            $request->file('event_image')->move($uploadDir, $imageName);
            session()->forget('temp_event_image');

            return $imageName;
        }

        if (!$this->isValidTempEventImageFilename($existingTempImage)) {
            throw ValidationException::withMessages([
                'event_image' => 'Please upload an event image.',
            ]);
        }

        $tempPath = $this->tempEventImagePath($existingTempImage);
        if (!is_file($tempPath)) {
            throw ValidationException::withMessages([
                'event_image' => 'The uploaded event image could not be found. Please upload it again.',
            ]);
        }

        $imageName = time() . '.' . pathinfo($existingTempImage, PATHINFO_EXTENSION);
        rename($tempPath, $uploadDir . '/' . $imageName);
        session()->forget('temp_event_image');

        return $imageName;
    }
}
