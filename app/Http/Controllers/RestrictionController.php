<?php

namespace App\Http\Controllers;

use App\Models\RestrictionModel;
use Illuminate\Http\Request;

class RestrictionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = RestrictionModel::orderBy('id', 'desc')->get();

        return view('admin.ticket_restrictions.list', compact('data'));
    }

    public function create()
    {
        return view('admin.ticket_restrictions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'restrictions' => 'required|string|max:255',
            'is_active' => 'nullable|in:0,1',
        ]);

        RestrictionModel::create([
            'restrictions' => $request->restrictions,
            'is_active' => $request->input('is_active', 1),
        ]);

        return redirect('ticket_restrictions/list')->with('success', 'Ticket restriction created successfully.');
    }

    public function show($id)
    {
        $data = RestrictionModel::findOrFail($id);

        return view('admin.ticket_restrictions.view', compact('data'));
    }

    public function edit($id)
    {
        $data = RestrictionModel::findOrFail($id);

        return view('admin.ticket_restrictions.edit', compact('data'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:tickets_restrictions,id',
            'restrictions' => 'required|string|max:255',
            'is_active' => 'nullable|in:0,1',
        ]);

        $restriction = RestrictionModel::findOrFail($request->id);
        $restriction->restrictions = $request->restrictions;
        $restriction->is_active = $request->input('is_active', 0);
        $restriction->save();

        return redirect('ticket_restrictions/list')->with('success', 'Ticket restriction updated successfully.');
    }

    public function delete($id)
    {
        $restriction = RestrictionModel::findOrFail($id);
        $restriction->delete();

        return redirect('ticket_restrictions/list')->with('success', 'Ticket restriction deleted successfully.');
    }
}
