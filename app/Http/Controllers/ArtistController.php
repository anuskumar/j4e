<?php

namespace App\Http\Controllers;

use App\Models\ArtistField;
use App\Models\ArtistModel;
use Illuminate\Http\Request;

class ArtistController extends Controller
{
    public function index(Request $request)
    {
        $query = ArtistModel::leftJoin('artist_field', 'artist_field.id', 'artist.field')
            ->select(
                'artist.*',
                'artist.id as id',
                'artist_field.field_name'
            );

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('artist.is_active', (int) $request->status);
        }

        if ($request->filled('field') && $request->field !== 'all') {
            $query->where('artist.field', (int) $request->field);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('artist.artist_name', 'like', '%' . $search . '%')
                    ->orWhere('artist.contact_number', 'like', '%' . $search . '%')
                    ->orWhere('artist.about', 'like', '%' . $search . '%')
                    ->orWhere('artist_field.field_name', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('registered_from')) {
            $query->whereDate('artist.created_at', '>=', $request->registered_from);
        }

        if ($request->filled('registered_to')) {
            $query->whereDate('artist.created_at', '<=', $request->registered_to);
        }

        $data = $query
            ->orderByDesc('artist.created_at')
            ->orderByDesc('artist.id')
            ->get();

        $artistFields = ArtistField::orderBy('field_name')->get();

        $filters = [
            'status' => $request->input('status', 'all'),
            'field' => $request->input('field', 'all'),
            'search' => $request->search,
            'registered_from' => $request->registered_from,
            'registered_to' => $request->registered_to,
        ];

        return view('admin.artist.list', compact('data', 'filters', 'artistFields'));
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
        $artist_create = ArtistField::orderBy('field_name')->get();

        return view('admin.artist.create', compact('artist_create'));
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
            'artist_name' => 'required|string|max:255',
            'field' => 'required|exists:artist_field,id',
            'contact_number' => 'nullable|string|max:20',
            'about' => 'nullable|string|max:1000',
        ], [
            'artist_name.required' => 'Artist name is required.',
            'field.required' => 'Artist field is required.',
            'field.exists' => 'Please select a valid artist field.',
        ]);

        $artistuser = new ArtistModel();
        $artistuser->artist_name = $request->artist_name;
        $artistuser->field = $request->field;
        $artistuser->contact_number = $request->contact_number;
        $artistuser->about = $request->about ?? '';
        $artistuser->save();
        return redirect('admin/artist/list')->with('success', 'Artist created successfully!');
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
       $data->about = $request->about ?? '';

    //   $data->status=$request->status;

       $data->save();
       return redirect('admin/artist/list');

     }
     public function delete( $id)
    {
        $data=ArtistModel::find($id);
        $data->delete($id);
        return redirect('/admin/artist/list');

    }
}
