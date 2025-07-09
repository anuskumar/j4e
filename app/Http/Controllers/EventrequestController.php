<?php

namespace App\Http\Controllers;

use App\Models\RequestEventModel;
use Illuminate\Http\Request;

class EventrequestController extends Controller
{
    public function requestevent(){

        return view('admin.reseller.requestevent');
    }


    public function requesteventstore(Request $request){
        $data =new RequestEventModel();
        $data->name = $request->name;
        $data->email = $request->email;
        $data->event_details = $request->event_details;
        $data->phone = $request->phone;
        $data->save();
        return redirect()->back()->with('success','Sent Request Successfully');

    }
}
