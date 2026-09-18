<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TagController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $tags = Tag::ordered()->get();

        return view('admin.eventtags.list', compact('tags'));
    }

    public function create()
    {
        $nextSortOrder = ((int) Tag::max('sort_order')) + 1;

        return view('admin.eventtags.create', compact('nextSortOrder'));
    }

    public function show(string $id)
    {
        $data = Tag::findOrFail($id);

        return view('admin.eventtags.view', compact('data'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tag_name' => 'required|string|max:255',
            'is_active' => 'nullable|in:0,1',
            'sort_order' => 'nullable|integer|min:0|max:9999',
            'tag_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $tagsdata = new Tag();
        $tagsdata->tag_name = $validated['tag_name'];
        $tagsdata->is_active = $request->input('is_active', 1);
        $tagsdata->sort_order = $validated['sort_order']
            ?? (((int) Tag::max('sort_order')) + 1);

        if ($request->hasFile('tag_image')) {
            $uploadDir = storage_path('uploads/event_tag_images');
            if (! is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $imageName = time() . '_' . uniqid() . '.' . $request->tag_image->extension();
            $request->tag_image->move($uploadDir, $imageName);
            $tagsdata->tag_image = $imageName;
        }

        $tagsdata->save();

        return redirect()->route('eventtags.list')->with('success', 'Event tag created successfully.');
    }

    public function edit($id)
    {
        $tagdata = Tag::findOrFail($id);

        return view('admin.eventtags.edit', compact('tagdata'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:event_tags,id',
            'tag_name' => 'required|string|max:255',
            'is_active' => 'nullable|in:0,1',
            'sort_order' => 'nullable|integer|min:0|max:9999',
            'tag_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $tagdata = Tag::findOrFail($request->id);
        $tagdata->tag_name = $validated['tag_name'];
        $tagdata->is_active = $request->input('is_active', 0);
        $tagdata->sort_order = $validated['sort_order'] ?? $tagdata->sort_order ?? 0;

        if ($request->hasFile('tag_image')) {
            $uploadDir = storage_path('uploads/event_tag_images');
            if (! is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            if ($tagdata->tag_image) {
                $currentImagePath = $uploadDir . '/' . $tagdata->tag_image;
                if (is_file($currentImagePath)) {
                    unlink($currentImagePath);
                }
            }

            $imageName = time() . '_' . uniqid() . '.' . $request->tag_image->extension();
            $request->tag_image->move($uploadDir, $imageName);
            $tagdata->tag_image = $imageName;
        }

        $tagdata->save();

        return redirect()->route('eventtags.list')->with('success', 'Event tag updated successfully.');
    }

    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'order' => 'required|array|min:1',
            'order.*' => 'integer|exists:event_tags,id',
        ]);

        DB::transaction(function () use ($validated) {
            foreach ($validated['order'] as $index => $id) {
                Tag::where('id', $id)->update([
                    'sort_order' => $index + 1,
                ]);
            }
        });

        return response()->json([
            'success' => true,
            'message' => 'Event tag order updated successfully.',
        ]);
    }

    public function delete($id)
    {
        $data = Tag::findOrFail($id);
        $data->delete();

        return redirect()->route('eventtags.list')->with('success', 'Event tag deleted successfully.');
    }
}
