<?php

namespace App\Http\Controllers;

use App\Models\Events;
use App\Models\SliderModel;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = SliderModel::orderBy('id', 'desc')->get();

        return view('admin.slide.list', compact('data'));
    }

    public function create()
    {
        $events = Events::orderBy('event_name')->get();

        return view('admin.slide.create', compact('events'));
    }

    public function show(Request $request)
    {
        $data = SliderModel::where('id', $request->id)->first();

        return view('admin.slide.view', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate($this->slideRules(false));

        $slider = new SliderModel();
        $this->fillSlideFromRequest($slider, $request);

        if ($request->hasFile('slide_image')) {
            $imageName = time() . '.' . $request->slide_image->extension();
            $request->slide_image->move(storage_path('uploads/slide'), $imageName);
            $slider->slide_image = $imageName;
        }

        $slider->save();

        return redirect('slide/list')->with('success', 'Slide created successfully.');
    }

    public function edit(Request $request, $id)
    {
        $data = SliderModel::find($id);
        $events = Events::orderBy('event_name')->get();

        return view('admin.slide.edit', compact('data', 'events'));
    }

    public function update(Request $request)
    {
        $request->validate($this->slideRules(true));

        $data = SliderModel::find($request->id);

        if (! $data) {
            return redirect('slide/list')->with('error', 'Slide not found');
        }

        $this->fillSlideFromRequest($data, $request);

        if ($request->hasFile('slide_image')) {
            $imageName = time() . '.' . $request->slide_image->extension();
            $request->slide_image->move(storage_path('uploads/slide'), $imageName);
            $data->slide_image = $imageName;
        }

        $data->save();

        return redirect('slide/list')->with('success', 'Slide updated successfully');
    }

    public function delete($id)
    {
        $data = SliderModel::find($id);
        $data->delete();

        return redirect('/slide/list');
    }

    private function slideRules(bool $isUpdate): array
    {
        $positions = implode(',', array_keys(SliderModel::DESCRIPTION_POSITIONS));
        $sizes = implode(',', array_keys(SliderModel::BUTTON_SIZES));

        return [
            'meta_description' => $isUpdate ? 'required|string' : 'nullable|string',
            'event' => 'nullable|exists:event,id',
            'is_active' => 'required|in:0,1',
            'text_color' => 'required|in:white,black',
            'description_position' => 'required|in:' . $positions,
            'show_button' => 'required|in:0,1',
            'button_text' => 'nullable|string|max:60',
            'button_color' => ['nullable', 'regex:/^#([A-Fa-f0-9]{3}|[A-Fa-f0-9]{6})$/'],
            'button_size' => 'required|in:' . $sizes,
            'button_position' => 'required|in:' . $positions,
            'slide_image' => ($isUpdate ? 'nullable' : 'nullable') . '|image|mimes:jpeg,png,jpg,webp|max:5120',
        ];
    }

    private function fillSlideFromRequest(SliderModel $slider, Request $request): void
    {
        $showButton = (int) $request->input('show_button', 0) === 1;
        $eventId = $request->input('event') ?: null;

        if ($showButton && empty($eventId)) {
            $showButton = false;
        }

        $slider->meta_description = $request->meta_description;
        $slider->eventid = $eventId;
        $slider->is_active = $request->is_active;
        $slider->text_color = $request->input('text_color', 'white');
        $slider->description_position = $request->input('description_position', 'left-center');
        $slider->show_button = $showButton ? 1 : 0;
        $slider->button_text = $request->input('button_text') ?: 'Book Now';
        $slider->button_color = $request->input('button_color') ?: '#671dcf';
        $slider->button_size = $request->input('button_size', 'medium');
        $slider->button_position = $request->input('button_position', 'right-bottom');
    }
}
