<?php

namespace App\Http\Controllers;

use App\Models\ArtistModel;
use App\Models\EventImages;
use App\Models\Events;
use App\Models\EventTags;
use App\Models\EventTiming;
use App\Models\EventType;
use App\Models\RequestEventModel;
use App\Models\TicketType;
use App\Models\VenueModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class EventsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {



        $data = Events::
        leftjoin('event_type','event_type.id','event.event_type')
        ->leftjoin('users','users.id','event.event_added_by')
        ->leftjoin('venue','venue.id','event.venue')->
        leftjoin('location','location.id','venue.location')
        ->leftjoin('countries','countries.id','location.country')
        ->leftjoin('cities','cities.id','location.city')
      ->select('*','event.id as id','country_name','cities.name as city_name','location_name','venue.name as venue_name')
       ->get();
    //    dd($data);
      return view('admin.events.list',compact('data'));

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
    // dd($event_type);
    return view('admin.events.create',compact('event_type','venue','artists','eventTags','ticketTypes'));

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
            'event_tag' => 'required'

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

        return view('admin.events.edit',compact('data','event_type','artists','venue','eventTags'));

     }
     public function update(Request $request){

        // dd($request->request);

        // dd( $request->artists);

        $validated = $request->validate([
            'event_name' => 'required',
            'event_tag' => 'required'

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
        $data->event_from_date = $request->event_from_date;
        $data->event_to_date = $request->event_to_date;
        $data->event_tag = $request->event_tag;
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
