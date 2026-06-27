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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $data = Events::
        leftjoin('event_type','event_type.id','event.event_type')
        ->leftjoin('users','users.id','event.event_added_by')
        ->leftjoin('venue','venue.id','event.venue')->
        leftjoin('location','location.id','venue.location')
        ->leftjoin('countries','countries.id','location.country')
        ->leftjoin('cities','cities.id','location.city')
      ->select('*','event.id as id','venue.id as id','country_name','cities.name as city_name','location_name','venue.name as venue_name')
       ->find($id);
    $artists = ArtistModel::leftjoin('artist_field','artist_field.id','artist.field')->select('*','artist.id as id')->get();

    //    dd($data);
        return view('admin.events.view',compact('data','artists'));
     }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->artists);
        $validated = $request->validate([
            'event_name' => 'required',
            'event_is_active' => 'required',
            'event_tag' => 'required',
            'seller_fee_percent' => 'required|numeric|min:0|max:100',
            'customer_fee_percent' => 'required|numeric|min:0|max:100',
            'event_start_time' => 'required|date_format:H:i',
            'event_end_time' => 'required|date_format:H:i|after:event_start_time',
        ]);

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
        $event->event_to_date = $request->event_to_date;
        $event->event_desc = $request->event_desc;
        $event->event_added_by =Auth::user()->id;
        // $event->event_image = $request->event_image;
        if($request->hasFile('event_image')){
            $imageName = time().'.'.$request->event_image->extension();
            $request->event_image->move(storage_path('uploads/events'), $imageName);
            $event->event_image =  $imageName;
        }
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
        $data=Events::find($id);
        // dd($data);
        $venue = VenueModel::
        leftjoin('location','location.id','venue.location')
       ->leftjoin('countries','countries.id','location.country')
       ->leftjoin('cities','cities.id','location.city')
       ->select('venue.id as id','country_name','cities.name as city_name','location_name','venue.name as venue_name')
       ->get();
    $artists = ArtistModel::leftjoin('artist_field','artist_field.id','artist.field')->select('*','artist.id as id')->get();
    $eventTags = EventTags::where('is_active',1)->get();
    $ticketTypes = TicketType::where('is_active', 1)->get();

        return view('admin.events.edit',compact('data','event_type','artists','venue','eventTags','ticketTypes'));

     }
     public function update(Request $request){

        // dd($request->request);

        // dd( $request->artists);

        $validated = $request->validate([
            'event_name' => 'required',
            'event_tag' => 'required',
            'seller_fee_percent' => 'required|numeric|min:0|max:100',
            'customer_fee_percent' => 'required|numeric|min:0|max:100',

            // 'event_is_active' => 'required'
        ]);

        $data = Events::find($request->id);
        $data->event_name = $request->event_name;
        $data->event_type = $request->event_type;
        $data->event_desc = $request->event_desc;
        $data->venue = $request->venue;

        if(!$request->artists==null){

        $data->artists = json_encode($request->artists);

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
        // $data->event_added_by =Auth::user()->id;
        $data->event_is_active = $request->event_is_active;

        // $event->event_image = $request->event_image;
        if($request->hasFile('event_image')){
            $imageName = time().'.'.$request->event_image->extension();
            $request->event_image->move(storage_path('uploads/events'), $imageName);
            $data->event_image =  $imageName;
        }
        // $data->event_is_active = $request->event_is_active;

        $data->save();


        return redirect('events/list');


     }
     public function delete( $id)
    {
        $data=Events::find($id);
        $data->delete();
        return redirect('/events/list');

    }


    public function multi_images($id){

        $data = EventImages::where('event',$id)->get();
        return view('admin.events.event_images',compact('data','id'));

    }

    public function upload_event_images(Request $request){

    //    dd($request->request);

        // if($request->hasFile('image')){
        //     foreach ($request->File('image') as $key) {
        //         $val = new EventImages();
        //         $val->event = $request->event;
        //         $imageName = time().'.'.Str::random(9).$key->extension();
        //         $key->move(storage_path('uploads/events'), $imageName);
        //         $val->image =  $imageName;
        //         $val->save();
        // }

        $images = [];

        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {
                $val = new EventImages();
                $val->event = $request->event;
                $filename = rand() . '.' . $file->getClientOriginalExtension();
                $file->move(storage_path('uploads/events'), $filename);
                $images[] = $filename;
                $val->image =  $filename;
                $val->save();
            }
        }

        return redirect()->back();
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
}
