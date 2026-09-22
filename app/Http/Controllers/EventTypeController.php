<?php

namespace App\Http\Controllers;

use App\Models\EventType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = EventType::ordered()->get();

        return view('admin.eventtype.list', compact('data'));
    }

    public function show(string $id)
    {
        $data = EventType::findOrFail($id);

        return view('admin.eventtype.view', compact('data'));
    }

    public function create()
    {
        $nextSortOrder = ((int) EventType::max('sort_order')) + 1;

        return view('admin.eventtype.create', compact('nextSortOrder'));
    }

    public function edit(string $id)
    {
        $data = EventType::findOrFail($id);

        return view('admin.eventtype.edit', compact('data'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'is_active' => 'nullable|in:0,1',
            'is_header_menu' => 'nullable|in:0,1',
            'sort_order' => 'nullable|integer|min:0|max:9999',
        ]);

        $eventtypeuser = new EventType();
        $eventtypeuser->event_type_name = $validated['name'];
        $eventtypeuser->is_active = $request->input('is_active', 1);
        $eventtypeuser->is_header_menu = $request->input('is_header_menu', 0);
        $eventtypeuser->sort_order = $validated['sort_order']
            ?? (((int) EventType::max('sort_order')) + 1);
        $eventtypeuser->save();

        return redirect('eventtype/list')->with('success', 'Event type created successfully.');
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:event_type,id',
            'event_type_name' => 'required|string|max:255',
            'is_active' => 'nullable|in:0,1',
            'is_header_menu' => 'nullable|in:0,1',
            'sort_order' => 'nullable|integer|min:0|max:9999',
        ]);

        $data = EventType::findOrFail($request->id);
        $data->event_type_name = $validated['event_type_name'];
        $data->is_active = $request->input('is_active', 0);
        $data->is_header_menu = $request->input('is_header_menu', 0);
        $data->sort_order = $validated['sort_order'] ?? $data->sort_order ?? 0;
        $data->save();

        return redirect('eventtype/list')->with('success', 'Event type updated successfully.');
    }

    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'order' => 'required|array|min:1',
            'order.*' => 'integer|exists:event_type,id',
        ]);

        DB::transaction(function () use ($validated) {
            foreach ($validated['order'] as $index => $id) {
                EventType::where('id', $id)->update([
                    'sort_order' => $index + 1,
                ]);
            }
        });

        return response()->json([
            'success' => true,
            'message' => 'Event type order updated successfully.',
        ]);
    }

    public function delete($id)
    {
        $data = EventType::findOrFail($id);
        $data->delete();

        return redirect('eventtype/list')->with('success', 'Event type deleted successfully.');
    }
}
