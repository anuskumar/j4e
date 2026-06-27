<?php

namespace App\Http\Controllers;

use App\Models\ArtistField;
use Illuminate\Http\Request;

class ArtistfiedController extends Controller
{
    public function index()
    {


        $data = ArtistField::orderBy('field_name')->get();

        return view('admin.artistfield.list', compact('data'));
    }

    public function show(string $id)
    {


        $data = ArtistField::find($id);
        // dd($data);
        return view('admin.artistfield.view',compact('data'));

     }

    public function create()
    {
        return view('admin.artistfield.create');
    }
    public function edit(string $id)
    {
        $data=ArtistField::find($id);


        return view('admin.artistfield.edit',compact('data'));

    }

    public function store(Request $request)
    {
        // dd($request->request);

        $validated = $request->validate([
            'field_name' => 'required|string|max:255',
        ]);

        $artistfielduser = new ArtistField();
        $artistfielduser->field_name = $validated['field_name'];
        $artistfielduser->save();

        return redirect('artistfield/list')->with('success', 'Artist field created successfully.');
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
