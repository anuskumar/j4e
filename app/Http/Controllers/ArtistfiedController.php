<?php

namespace App\Http\Controllers;

use App\Models\ArtistField;
use Illuminate\Http\Request;

class ArtistfiedController extends Controller
{
    public function index()
    {


        $data = ArtistField::get();
        // dd($data);
        return view('admin.artistfield.list',compact('data'));

    }

    public function show(string $id)
    {


        $data = ArtistField::find($id);
        // dd($data);
        return view('admin.artistfield.view',compact('data'));

     }

    public function create()
    {
        //
        $artistfield_create=ArtistField::get();
        //  dd($customer_create);
            return view('admin.artistfield.create',compact('artistfield_create'));

    }
    public function edit(string $id)
    {
        $data=ArtistField::find($id);


        return view('admin.artistfield.edit',compact('data'));

    }

    public function store(Request $request)
    {
        // dd($request->request);

        // $validated = $request->validate([
        //     'field_name' => 'required',

        // ]);

        $artistfielduser = new ArtistField();
        $artistfielduser->field_name = $request->field_name;

        $artistfielduser->save();
        return redirect('artistfield/list');
     }
     public function update(Request $request){

        // $validated = $request->validate([
        //     'id' => 'required',
        //     'artist_name' => 'required',

        // ]);

       $data=ArtistField::find($request->id);
       $data->field_name = $request->field_name;

    //   $data->status=$request->status;

       $data->save();
       return redirect('artistfield/list');

     }
     public function delete( $id)
    {
        $data=ArtistField::find($id);
        $data->delete($id);
        return redirect('/artistfield/list');

    }
}
