<?php

namespace App\Http\Controllers;

use App\Models\VenueType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class VenueTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {

        $data = VenueType::orderBy('id', 'desc')->get();
        // dd($data);
        return view('admin.venuetype.list',compact('data'));

    }

    public function show(string $id)
    {


        $data = VenueType::find($id);
        // dd($data);
        return view('admin.venuetype.view',compact('data'));


        // $data = VenueModel::find($id);
        // return view('admin.venue.view',compact('data'));
     }

    public function create()
    {
        //
        $venuetype_create=VenueType::get();
        //  dd($customer_create);
            return view('admin.venuetype.create',compact('venuetype_create'));

    }
    public function edit(string $id)
    {
       $data=VenueType::find($id);
       $venue_type_name = VenueType::get();
       $status=VenueType::get();
       return view('admin.venuetype.edit',compact('venue_type_name','status','data'));

    }

    public function store(Request $request)
    {
        $venuetypeuser = new VenueType();
        $venuetypeuser->venue_type_name = $request->name;
        $venuetypeuser->is_active = $request->is_active;
        $venuetypeuser->save();
        return redirect('venuetype/list');

     }
     public function update(Request $request){

        $validated = $request->validate([
            'id' => 'required',

        ]);

       $data=VenueType::find($request->id);
       $data->venue_type_name=$request->venue_type_name;
       $data->is_active = $request->is_active;

    //   $data->status=$request->status;

       $data->save();
       return redirect('venuetype/list');

     }
     public function delete( $id)
    {
        $data=VenueType::find($id);
        $data->delete();
        return redirect('/venuetype/list');

    }
}
