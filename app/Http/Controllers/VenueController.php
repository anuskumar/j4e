<?php

namespace App\Http\Controllers;

use App\Models\CityModel;
use App\Models\LocationModel;
use App\Models\VenueModel;
use App\Models\VenueSeating;
use App\Models\VenueType;
use Illuminate\Http\Request;

class VenueController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {

        $data = VenueModel::
        leftjoin('venue_type','venue_type.id','venue.venue_type')->
        leftjoin('location','location.id','venue.location')->
        leftjoin('countries','countries.id','location.country')
        ->leftjoin('cities','cities.id','location.city')->
        select("*","venue.id as id","venue.name as venue_name")->
        orderBy('venue.id', 'desc')->
        get();

        foreach($data as $val){
            $val['total_seats'] = VenueSeating::where('venue',$val->id)->sum('number_of_seats');
            $val['total_seat_types'] = VenueSeating::where('venue',$val->id)->count();
        }
        // dd($data)
        return view('admin.venue.list',compact('data'));

    }

    public function manage_Seating($id){

        $data = VenueSeating::where('venue',$id)->get();

        return view('admin.venue.manage_seating',compact('data','id'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $venue_create=VenueModel::get();
    //  dd($customer_create);
        $venue_type = VenueType::get();
        $location = LocationModel::
        leftjoin('countries','countries.id','location.country')
        ->leftjoin('cities','cities.id','location.city')
        ->select('*','location.id as id')
        ->get();
        return view('admin.venue.create',compact('venue_type','location'));
     }
     public function show(string $id)
    {


        $data = VenueModel::
        leftjoin('venue_type','venue_type.id','venue.venue_type')->
        leftjoin('location','location.id','venue.location')->
        leftjoin('countries','countries.id','location.country')
        ->leftjoin('cities','cities.id','location.city')->
        select("*","venue.id as id","venue.name as venue_name")->
        find($id);
        // dd($data);
        return view('admin.venue.view',compact('data'));


        // $data = VenueModel::find($id);
        // return view('admin.venue.view',compact('data'));
     }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'location' => 'required',
            'venue_type' => 'required',
        ]);
        // dd($request->request);
        $venue = new VenueModel();
        $venue->venue_type = $request->venue_type;
        $venue->name = $request->name;
        $venue->location = $request->location;
        $venue->google_map_link = $request->google_map_link;
        $venue->latitude = $request->latitude;
        $venue->longitude = $request->longitude;
        // $venue->image = $request->image;
        if($request->hasFile('image')){
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(storage_path('uploads/venue'), $imageName);
            $venue->image =  $imageName;
        }
        $venue->save();

        return redirect('venue/list');
     }
     public function edit(string $id)
     {
        $data=VenueModel::find($id);
        $venue_type = VenueType::get();
        $location = LocationModel::
        leftjoin('countries','countries.id','location.country')
        ->leftjoin('cities','cities.id','location.city')
        ->select('*','location.id as id')
        ->get();
        return view('admin.venue.edit',compact('venue_type','location','data'));

     }
     public function update(Request $request){

        $validated = $request->validate([
            'id' => 'required',
            'venue_type' => 'required',
        ]);

       $data=VenueModel::find($request->id);
       $data->venue_type=$request->venue_type;
       $data->name=$request->name;
       $data->location=$request->location;
       $data->google_map_link=$request->google_map_link;
       $data->image = $request->image;
        if($request->hasFile('image')){
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(storage_path('uploads/venue'), $imageName);
            $data->image =  $imageName;
        }
       $data->save();
       return redirect('venue/list');

     }
     public function delete( $id)
    {
        $data=VenueModel::find($id);
        $data->delete();
        return redirect('/venue/list');

    }

    public function store_seating(Request $request){

        // dd($request->request);

        $validated = $request->validate([
            'venue' => 'required',
            'seating_type_name' => 'required',
            'number_of_seats' => 'required',
            'seat_serial_prefix' => 'required',

        ]);

        $data = new VenueSeating();
        $data->venue = $request->venue;
        $data->seating_type_name = $request->seating_type_name;
        $data->number_of_seats = $request->number_of_seats;
        $data->seat_serial_prefix = $request->seat_serial_prefix;
        $data->seat_serial_start = $request->seat_serial_start;
        $data->seat_serial_end = $request->seat_serial_end;
        $data->seating_type_desc = $request->seating_type_desc;
        $data->is_active = $request->is_active;

        if($request->hasFile('seating_image')){
            $imageName = time().'.'.$request->seating_image->extension();
            $request->seating_image->move(storage_path('uploads/venue_seating'), $imageName);
            $data->seating_image =  $imageName;
        }

        $data->save();

        return back();

    }

    public function edit_seating( string $id){

        $data = VenueSeating::find($id);

        return view('admin.venue.edit_seating',compact('data','id'));
        // $data = VenueSeating::where('venue',$id)->get();

        // return view('admin.venue.edit_seating',compact('data','id'));


    }

public function update_Seating(Request $request){

    // dd($request->request);
    $validated = $request->validate([

                    'number_of_seats' => 'required',
                    'seat_serial_prefix' => 'required',

    ]);

   $data=VenueSeating::find($request->id);
   $data->id=$request->id;
   $data->seating_type_name=$request->seating_type_name;
   $data->number_of_seats=$request->number_of_seats;
   $data->seat_serial_prefix=$request->seat_serial_prefix;
   $data->seat_serial_start=$request->seat_serial_start;
   $data->seat_serial_end=$request->seat_serial_end;
   $data->seating_type_desc=$request->seating_type_desc;
   $data->is_active = $request->is_active;
//    $data->image = $request->image;

        if($request->hasFile('seating_image')){
            $imageName = time().'.'.$request->seating_image->extension();
            $request->seating_image->move(storage_path('uploads/venue_seating'), $imageName);
            $data->seating_image =  $imageName;
        }
   $data->save();

return redirect('venue/manage_Seating'.'/'.$data->venue);

 }

 public function delete_seating( $id)
    {
        $data=VenueSeating::find($id);
        $data->delete();
        return redirect()->back()->with('success','Updated Successfully');

    }

    public function getCity($countryId)
    {
        info($countryId);
        $cities = CityModel::where('country_id', $countryId)->pluck('name', 'id');
        return response()->json($cities);
    }

}


