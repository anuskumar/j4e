<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;

class TagController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $tags=Tag::get();
        return view('admin.eventtags.list',compact('tags'));

    }

    public function create(){
        return view('admin.eventtags.create');
    }
    public function store(Request $request)
    {
        $tagsdata=new Tag();
        $tagsdata->tag_name=$request->tag_name;

        if($request->hasFile('tag_image')){
            $imageName = time().'.'.$request->tag_image->extension();
            $request->tag_image->move(storage_path('uploads/event_tag_images'), $imageName);
            $tagsdata->tag_image =  $imageName;
        }
        $tagsdata->is_active=$request->is_active;
        $tagsdata->save();

        // return back();
        return redirect()->route('eventtags.list');

    }
    public function edit(Request $request,$id)
    {
       $tagdata= Tag::find($id);
       return view('admin.eventtags.edit',compact('tagdata'));
    }
    public function update(Request $request)
    {

        $id=$request->id;
        $tagdata= Tag::find($id);
        $tagdata->tag_name=$request->tag_name;
        $tagdata->is_active=$request->is_active;

        if($request->hasFile('tag_image')){
            $currentImagePath = storage_path('uploads/event_tag_images') . '/' . $tagdata->tag_image;

            if (is_file($currentImagePath)) {
                unlink($currentImagePath);
            }
            $imageName = time().'.'.$request->tag_image->extension();
            $request->tag_image->move(storage_path('uploads/event_tag_images'), $imageName);
            $tagdata->tag_image =  $imageName;
        }

        $tagdata->save();
        return redirect()->route('eventtags.list');
    }
    public function delete(Request $request,$id){
        $data=Tag::find($id);
        $data->delete();
        return redirect()->route('eventtags.list');
    }
}


