<?php

namespace App\Http\Controllers;

use App\Models\VenueType;
use Illuminate\Http\Request;

class VenueTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = VenueType::orderBy('id', 'desc')->get();

        return view('admin.venuetype.list', compact('data'));
    }

    public function show(string $id)
    {
        $data = VenueType::findOrFail($id);

        return view('admin.venuetype.view', compact('data'));
    }

    public function create()
    {
        return view('admin.venuetype.create');
    }

    public function edit(string $id)
    {
        $data = VenueType::findOrFail($id);

        return view('admin.venuetype.edit', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'is_active' => 'nullable|in:0,1',
        ]);

        $venuetype = new VenueType();
        $venuetype->venue_type_name = $request->name;
        $venuetype->is_active = $request->input('is_active', 1);
        $venuetype->save();

        return redirect('venuetype/list')->with('success', 'Venue type created successfully.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:venue_type,id',
            'venue_type_name' => 'required|string|max:255',
            'is_active' => 'nullable|in:0,1',
        ]);

        $data = VenueType::findOrFail($request->id);
        $data->venue_type_name = $request->venue_type_name;
        $data->is_active = $request->input('is_active', 0);
        $data->save();

        return redirect('venuetype/list')->with('success', 'Venue type updated successfully.');
    }

    public function delete($id)
    {
        $data = VenueType::findOrFail($id);
        $data->delete();

        return redirect('venuetype/list')->with('success', 'Venue type deleted successfully.');
    }
}
