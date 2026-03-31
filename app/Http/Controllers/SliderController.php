<?php

namespace App\Http\Controllers;

use App\Models\Events;
use App\Models\SliderModel;
use Illuminate\Console\Scheduling\Event;
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
        // dd($data);
        return view('admin.slide.list',compact('data'));

    }

    public function create()
    {
        $data = SliderModel::get();
        $events=Events::get();
        // dd($data);
        return view('admin.slide.create',compact('events'));

     }
     public function show(Request $request)
     {
         $data = SliderModel::where('id',$request->id)->first();
         // dd($data);
         return view('admin.slide.view',compact('data'));

      }


     public function store(Request $request)
     {
         $request->all();
        $slider = new SliderModel();
        // $slider->slide_image = $request->slide_image;
        $slider->meta_description = $request->meta_description;
        $slider->eventid= $request->event;
        $slider->is_active = $request->is_active;
        if($request->hasFile('slide_image')){
        $imageName = time().'.'.$request->slide_image->extension();
        $request->slide_image->move(storage_path('uploads/slide'), $imageName);
        $slider->slide_image =  $imageName;
        }

        $slider->save();
        return redirect('slide/list');


      }
      public function edit(Request $request,$id){
        $data=SliderModel::find($id);
        return view('admin.slide.edit',compact('data'));

      }

      public function update(Request $request) {
        $validated = $request->validate([
            'meta_description' => 'required',
            'is_active' => 'required',
         //   'slide_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Add appropriate validation rules for image uploads
        ]);

        // Find the record to update
        $data = SliderModel::find($request->id);

        if (!$data) {
            return redirect('slide/list')->with('error', 'Slide not found');
        }

        // Update the fields
        $data->meta_description = $request->meta_description;
        $data->is_active = $request->is_active;

        if ($request->hasFile('slide_image')) {
            // Handle image upload
            $imageName = time() . '.' . $request->slide_image->extension();
            $request->slide_image->move(storage_path('uploads/slide'), $imageName);
            $data->slide_image = $imageName;
        }

        // Save the updated record
        $data->save();

        return redirect('slide/list')->with('success', 'Slide updated successfully');
    }

    public function delete( $id)
    {
        $data=SliderModel::find($id);
        // unlink(storage_path('uploads/slide/'. $data->slide_image));
          $data->delete();

        return redirect('/slide/list');

    }
}
