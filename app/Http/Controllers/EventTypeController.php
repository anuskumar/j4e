<?php

namespace App\Http\Controllers;

use App\Models\EventType;
use Illuminate\Http\Request;

class EventTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {

        $data = EventType::get();
        // dd($data);
        return view('admin.eventtype.list',compact('data'));

    }

    public function show(string $id)
    {


        $data = EventType::find($id);
        // dd($data);
        return view('admin.eventtype.view',compact('data'));


        // $data = VenueModel::find($id);
        // return view('admin.venue.view',compact('data'));
     }

    public function create()
    {
        //
        $eventtype_create=EventType::get();
        //  dd($customer_create);
            return view('admin.eventtype.create',compact('eventtype_create'));

    }
    public function edit(string $id)
    {
       $data=EventType::find($id);
       $event_type_name = EventType::get();
       $status=EventType::get();
       return view('admin.eventtype.edit',compact('event_type_name','status','data'));

    }

    public function store(Request $request)
    {
        $eventtypeuser = new EventType();
        $eventtypeuser->event_type_name = $request->name;
        $eventtypeuser->is_active = $request->is_active;
        $eventtypeuser->save();
        return redirect('eventtype/list');
     }
     public function update(Request $request){

        $validated = $request->validate([
            'id' => 'required',

        ]);

       $data=EventType::find($request->id);
       $data->event_type_name=$request->event_type_name;
       $data->is_active = $request->is_active;


    //   $data->status=$request->status;

       $data->save();
       return redirect('eventtype/list');

     }
     public function delete( $id)
    {
        $data=EventType::find($id);
        $data->delete();
        return redirect('/eventtype/list');

    }
}
