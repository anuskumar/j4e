<?php

namespace App\Http\Controllers;

use App\Models\TicketType;
use Illuminate\Http\Request;

class TicketTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $data = TicketType::orderBy('id')->get();

        return view('admin.tickettype.list', compact('data'));

    }

    public function show(string $id)
    {


        $data = TicketType::find($id);
        // dd($data);
        return view('admin.tickettype.view',compact('data'));


        // $data = VenueModel::find($id);
        // return view('admin.venue.view',compact('data'));
     }

    public function create()
    {
        //
        $tickettype_create=TicketType::get();
        //  dd($customer_create);
            return view('admin.tickettype.create',compact('tickettype_create'));

    }
    public function edit(string $id)
    {
       $data=TicketType::find($id);
       $ticket_type_name = TicketType::get();
       $status=TicketType::get();
       return view('admin.tickettype.edit',compact('ticket_type_name','status','data'));

    }

    public function store(Request $request)
    {
        $tickettypeuser = new TicketType();
        $tickettypeuser->ticket_type_name = $request->name;
        $tickettypeuser->is_active = $request->is_active;
        $tickettypeuser->save();
        return redirect('tickettype/list');
     }
     public function update(Request $request){

        $validated = $request->validate([
            'id' => 'required',

        ]);

       $data=TicketType::find($request->id);
       $data->ticket_type_name=$request->ticket_type_name;
       $data->is_active = $request->is_active;


    //   $data->status=$request->status;

       $data->save();
       return redirect('tickettype/list');

     }
     public function delete( $id)
    {
        $data=TicketType::find($id);
        $data->delete();
        return redirect('/tickettype/list');

    }
}
