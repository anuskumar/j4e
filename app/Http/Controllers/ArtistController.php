<?php

namespace App\Http\Controllers;

use App\Models\ArtistField;
use App\Models\ArtistModel;
use Illuminate\Http\Request;

class ArtistController extends Controller
{
    public function index()
    {


        $data=ArtistModel::leftjoin('artist_field','artist_field.id','artist.field')->select('*','artist.id as id','field_name')->get();
        // dd($data);
        return view('admin.artist.list',compact('data'));


    }

    public function show(string $id)
    {


        $data = ArtistModel::find($id);
        $artist=ArtistModel::leftjoin('artist_field','artist_field.id','artist.field')->select('*','artist.id as id','field_name')->get();
        // dd($data);
        return view('admin.artist.view',compact('data','artist'));


        // $data = VenueModel::find($id);
        // return view('admin.venue.view',compact('data'));
     }

    public function create()
    {
        //
        $artist_create=ArtistField::get();
        //  dd($customer_create);
        $artist=ArtistModel::leftjoin('artist_field','artist_field.id','artist.field')->select('*','artist.id as id')->get();
            return view('admin.artist.create',compact('artist_create','artist'));

    }
    public function edit(string $id)
    {
       $data=ArtistModel::leftjoin('artist_field','artist_field.id','artist.field')->select('*','artist.id as id')->find($id);;
       $artist_create = ArtistField::get();

       return view('admin.artist.edit',compact('artist_create','data'));

    }

    public function store(Request $request)
    {
        // dd($request->request);

        $validated = $request->validate([
            'artist_name' => 'required',

        ]);

        $artistuser = new ArtistModel();
        $artistuser->artist_name = $request->artist_name;
        $artistuser->field = $request->field;
        $artistuser->contact_number = $request->contact_number;
        $artistuser->about = $request->about;
        $artistuser->save();
        return redirect('artist/list');
     }
     public function update(Request $request){

        $validated = $request->validate([
            'id' => 'required',
            'artist_name' => 'required',

        ]);

       $data=ArtistModel::find($request->id);
       $data->artist_name = $request->artist_name;
       $data->field = $request->field;
       $data->contact_number = $request->contact_number;
       $data->about = $request->about;

    //   $data->status=$request->status;

       $data->save();
       return redirect('artist/list');

     }
     public function delete( $id)
    {
        $data=ArtistModel::find($id);
        $data->delete($id);
        return redirect('/artist/list');

    }
}
