<?php

namespace App\Http\Controllers;
use App\Models\User;

use App\Mail\TicketApprovedMail;
use App\Models\Events;
use App\Models\EventTickets;
use App\Models\EventTiming;
use App\Models\TicketsGenerated;
use App\Models\TicketType;
use App\Models\Currency;
use App\Models\OutsideSellModel;
use App\Models\RestrictionModel;
use App\Models\VenueSeating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Emailj4eController;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        //
                // dd('hello');

        $data_all = Events::
        leftjoin('event_type','event_type.id','event.event_type')
        ->leftjoin('users','users.id','event.event_added_by')
        ->leftjoin('venue','venue.id','event.venue')->
        leftjoin('location','location.id','venue.location')
        ->leftjoin('countries','countries.id','location.country')
        ->leftjoin('cities','cities.id','location.city');

        if(!Auth::user()->user_type=="superadmin"){

            $data_all->where('event.event_added_by',Auth::user()->id);
        }

        $data = $data_all->select('*','event.id as id','event.event_name as event_name','country_name','cities.name as city_name','location_name','venue.name as venue_name','event.created_at as created_at')
       ->latest('event.id')->get();

       foreach($data as $val){

        $val['waiting_for_approval'] = EventTickets::where('event_tickets.event',$val->id)->where('is_admin_approved',0)->count();
        $val['my_tickets'] = EventTickets::where('event_tickets.event',$val->id)->where('created_by',Auth::user()->id)->count();

       }
    //  dd($data);
      return view('admin.tickets.ticket_events',compact('data'));


    }

    /**
     * Show the form for creating a new resource.
     */

    // public function manage_tickets($id){

    //     $data_all = EventTickets::leftjoin('ticket_type','ticket_type.id','event_tickets.ticket_type')
    //     ->leftjoin('event','event.id','event_tickets.event')
    //     ->leftjoin('venue','venue.id','event.venue')
    //     ->leftjoin('venue_seating','venue_seating.id','event_tickets.venue_seating')
    //     ->leftjoin('event_timings','event_timings.id','event_tickets.event_timing')
    //     ->leftjoin('ticket_status','ticket_status.id','event_tickets.ticket_status')
    //     ->where('event_tickets.event',$id);
    //     if(!Auth::user()->user_type=="reseller"){

    //         // $data_all->where('event.event_added_by',Auth::user()->id);
    //         $data_all->where('event_tickets.created_by',Auth::user()->id);

    //         }

    //     $data = $data_all->select('*','event_tickets.id as id','event_tickets.is_admin_approved as is_admin_approved')->get();
    //     // dd($data);


    //     $event = Events::find($id);
    //     $ticket_type =TicketType::get();
    //     $event_timing = EventTiming::where('event',$id)->get();
    //     $venue_seatings = VenueSeating::leftjoin('venue','venue.id','venue_seating.venue')
    //     ->where('venue.id',$event->venue)->select('*','venue_seating.id as id')->get();
    //     $currency  = Currency::get();
    //     $restrictions = RestrictionModel::get();
    //     // dd($data);
    //     return view('admin.tickets.ticket_list',compact('data','id','ticket_type','event_timing','venue_seatings','currency','restrictions'));


    //  }
    public function manage_tickets($id){
        $data_all = EventTickets::leftjoin('ticket_type','ticket_type.id','event_tickets.ticket_type')
            ->leftjoin('event','event.id','event_tickets.event')
            ->leftjoin('venue','venue.id','event.venue')
            ->leftjoin('venue_seating','venue_seating.id','event_tickets.venue_seating')
            ->leftjoin('event_timings','event_timings.id','event_tickets.event_timing')
            ->leftjoin('ticket_status','ticket_status.id','event_tickets.ticket_status')
            ->where('event_tickets.event', $id);
            // info(Auth::user()->user_type);
            if(Auth::user()->user_type != 'superadmin')
            {
                $data_all->where('event_tickets.created_by', Auth::user()->id);
            }

        // Filter tickets based on the authenticated user's ID (created_by)


        $data = $data_all->select('*','event_tickets.id as id','event_tickets.is_admin_approved as is_admin_approved')->latest('event_tickets.created_at')->get();

        $event = Events::find($id);
        $ticket_type = TicketType::get();
        $event_timing = EventTiming::where('event', $id)->get();
        $venue_seatings = VenueSeating::leftjoin('venue','venue.id','venue_seating.venue')
            ->where('venue.id', $event->venue)->select('*','venue_seating.id as id')->get();
        $currency  = Currency::get();
        $restrictions = RestrictionModel::get();

        return view('admin.tickets.ticket_list', compact('data', 'id', 'ticket_type', 'event_timing', 'venue_seatings', 'currency', 'restrictions'));
    }



     public function check_availability(Request $request){

        $validated = $request->validate([
            'seating' => 'required|numeric',
            'timing' => 'required|numeric',
            'event' => 'required|numeric',

        ]);

            $data= [];

            $seating = $request->seating;
            $timing = $request->timing;
            $event = $request->event;
            $data['status'] = true;
            $seating_data = VenueSeating::find($seating);
            $count = TicketsGenerated::where('event_id',$event)->where('event_timing',$timing)->where('event_seating',$seating)->count();
            if($count>=$seating_data->number_of_seats){
                // dd($count);

                $data['status'] = false;
                $data['message'] = "Tickets for all Seats are Created for This Seating";
                $data['seats'] ='';
            }else{


                $data['status'] = true;
                $data['message'] = "Ticket spaces are available";
                $data['seats'] = $seating_data->number_of_seats - $count ;


            }


            return Response::json($data);

     }

       public function reject_tickets(Request $request){

          $data =[];
          $id = $request->ticket_id;
          $new = EventTickets::find($id);
                $new->is_admin_approved = 2;
                $new->save();
                $data['status'] = true;
                $data['message'] = "Rejected";
          return Response::json($data);

       }

     public function approve_tickets(Request $request){


        $validated = $request->validate([
            'ticket_id' => 'required|numeric',

        ]);
        $id = $request->ticket_id;
        $user_id = $request->created_by;
        $user = User::where('id',$user_id)->first();

       $ticket=  EventTickets::find($id);
       $seating = VenueSeating::find($ticket->venue_seating);
       $event = Events::where('id',$ticket->event)->first();

       if($seating==null){

        $data['status'] = false;
        $data['message'] = "Cannot Approve..venue seating has some issues ..please check that";
        return Response::json($data);
       }
       $count = TicketsGenerated::where('event_id',$ticket->event)
       ->where('event_timing',$ticket->event_timing)
       ->where('event_seating',$ticket->venue_seating)->count();
    //    $remaining = $seating->number_of_seats - $count;
       $diff = $ticket->seat_to - $ticket->seat_from;
    //    dd($ticket->no_of_tickets);
       $data= [];
    //    if($ticket->no_of_tickets == ($diff+1)){

        // $i = $ticket->seat_from;

        for ($i=$ticket->seat_from; $i <= $ticket->seat_to; $i++){

            $new_generate = new TicketsGenerated();
            $new_generate->event_tickets = $id;
            $new_generate->ticket_serial_number = $seating->seat_serial_prefix.$i.'-'.$ticket->row.'-'.time();
            $new_generate->is_sold = 0;
            $new_generate->under_purchase_hold = 0;
            $new_generate->ticket_amount = $ticket->ticket_amount;
            $new_generate->seat_number = $i;
            $new_generate->seat_row = $ticket->row;
            $new_generate->seat_prefix =$seating->seat_serial_prefix;
            $new_generate->seat_number_prefix =$seating->seat_serial_prefix.'-'.$ticket->row.'-'.$i;
            $new_generate->event_timing = $ticket->event_timing;
            $new_generate->event_seating = $ticket->venue_seating;
            $new_generate->event_id = $ticket->event;
            $new_generate->save();
        }
                $new = EventTickets::find($id);
                $new->is_admin_approved = 1;
                $new->save();
                $data['status'] = true;
                $data['message'] = "Approved";
            // }
            // else{
            //     $data['status'] = false;
            //     $data['message'] = "Cannot Approve..Seat Count Has Errors";
            // }




            $maildata = [
                'email' => $user->email,
                'resellername' => $user->name,
                'eventname' => $event->event_name,
                'eventdate' => $event->event_from_date,
                'numberoftickets' => $count,
                 'totalamount' => $ticket->ticket_amount
            ];

    // $userEmail = 'sheebarobert18@gmail.com';

    $emailController = new Emailj4eController();
    $emailController->ticketapprovedmail($maildata);

       return Response::json($data);

     }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // dd($request->all());
        if ($request->post('event_id') == '') {
            $validated = $request->validate([
                'event' => 'required|numeric',
                'ticket_name' => 'required',
                'event_timing' => 'required|numeric',
                'no_of_tickets' => 'required|numeric',
                'ticket_amount' => 'required|numeric',
                'face_value' => 'required|numeric',
                'amount_currency' => 'required|numeric',
                'row' => 'required|numeric',
                'seat_from' => 'required|numeric',
                'seat_to' => 'required|numeric',



            ]);
            $data = new EventTickets;
          } else {
            $data = EventTickets::find($request->post('event_id'));
            info($data);
        }
        $data->ticket_name = $request->ticket_name;
        $data->ticket_type = $request->ticket_type;
        $data->event = $request->event;
        $data->event_timing = $request->event_timing;
        $data->no_of_tickets = $request->no_of_tickets;
        $data->booking_expiry_date_time = $request->booking_expiry_date_time;
        $data->no_of_tickets = $request->no_of_tickets;
        $data->venue_seating = $request->venue_seating;
        $data->ticket_amount = $request->ticket_amount;
        $data->amount_currency = $request->amount_currency;
        $data->cancellation_policy_notes = $request->cancellation_policy_notes;
        $data->disclaimer_note = $request->disclaimer_note;
        $data->row = $request->row;
        $data->seat_from = $request->seat_from;
        $data->seat_to = $request->seat_to;
        $data->face_value = $request->face_value;
        $data->web_price = $request->face_value;
        if ($request->post('event_id') == '') {
            $data->ticket_restrictions = json_encode($request->ticket_restrictions);
        }

        if($request->hasFile('image')){
            $currentImagePath = storage_path('uploads/ticket_images') . '/' . $data->image;

            if (is_file($currentImagePath)) {
                unlink($currentImagePath);
            }
            $imageName = rand().'.'.$request->image->extension();
            $request->image->move(storage_path('uploads/ticket_images'), $imageName);
            $data->image =  $imageName;
        }

        // if($request->hasFile('cover_image')){
        //     $currentImagePath = storage_path('uploads/ticket_images') . '/' . $data->cover_image;

        //     if (is_file($currentImagePath)) {
        //         unlink($currentImagePath);
        //     }
        //     $imageName = rand().'.'.$request->cover_image->extension();
        //     $request->cover_image->move(storage_path('uploads/ticket_images'), $imageName);
        //     $data->cover_image =  $imageName;
        // }
        // if($request->hasFile('map_layout')){
        //     $currentImagePath = storage_path('uploads/ticket_images') . '/' . $data->map_layout;

        //     if (is_file($currentImagePath)) {
        //         unlink($currentImagePath);
        //     }
        //     $imageName = rand().'.'.$request->map_layout->extension();
        //     $request->map_layout->move(storage_path('uploads/ticket_images'), $imageName);
        //     $data->map_layout =  $imageName;
        // }
        if($request->hasFile('ticket_upload')){
            $currentImagePath = storage_path('uploads/ticket_images') . '/' . $data->ticket_upload;

            if (is_file($currentImagePath)) {
                unlink($currentImagePath);
            }
            $imageName = rand().'.'.$request->ticket_upload->extension();
            $request->ticket_upload->move(storage_path('uploads/ticket_images'), $imageName);
            $data->ticket_upload =  $imageName;
        }


        $data->is_admin_approved = 0;
        $data->ticket_status = 1;
        $data->created_by = Auth::user()->id;
        $data->save();

        // dd($request->request);
        if ($request->post('event_id')) {
            return back()->with('success', 'Ticket Updated successfully');
            // return redirect('tickets/manage_tickets'.'/'.$request->event)->with('success','Ticket Updated successfully');

        } else{
            return back()->with('success', 'Ticket Created successfully');

            // return redirect('tickets/manage_tickets'.'/'.$request->event)->with('success','Ticket Created successfully');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = EventTickets::
        leftjoin('ticket_type','ticket_type.id','event_tickets.ticket_type')
        ->leftjoin('event','event.id','event_tickets.event')
        ->leftjoin('venue','venue.id','event.venue')
        ->leftjoin('venue_seating','venue_seating.id','event_tickets.venue_seating')
        ->leftjoin('event_timings','event_timings.id','event_tickets.event_timing')
        ->leftjoin('ticket_status','ticket_status.id','event_tickets.ticket_status')
        ->where('event_tickets.id',$id)
        ->select('*','event_tickets.id as id')->first();

        // dd($data);
        return view('admin.tickets.ticket_view',compact('data'));


    }

    /**
     * Show the form for editing the specified resource.
     */
    public function ticket_edit(string $id)
    {
        //
        // info($id);
        $data = EventTickets::
        leftjoin('ticket_type','ticket_type.id','event_tickets.ticket_type')
        ->leftjoin('event','event.id','event_tickets.event')
        ->leftjoin('venue','venue.id','event.venue')
        ->leftjoin('venue_seating','venue_seating.id','event_tickets.venue_seating')
        ->leftjoin('event_timings','event_timings.id','event_tickets.event_timing')
        ->leftjoin('ticket_status','ticket_status.id','event_tickets.ticket_status')
        ->where('event_tickets.id',$id)
        ->select('*','event_tickets.id as id')->first();

        $ticket_type =TicketType::get();
        $event_timing = EventTiming::where('event',$data->event)->get();

        $venue_seatings = VenueSeating::leftjoin('venue','venue.id','venue_seating.venue')
        ->where('venue.id',$data->venue)->select('*','venue_seating.id as id')->get();
        $currency  = Currency::get();
        $restrictions = RestrictionModel::get();
        // dd($data);
        return view('admin.tickets.ticket_edit',compact('data','ticket_type','event_timing','venue_seatings','currency','restrictions'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete_main_ticket(string $id)
    {

        $data = EventTickets::find($id);
        $data->delete();

        $sub_tickets = TicketsGenerated::where('event_tickets',$id)->delete();
        return redirect()->back()->with('success','Ticket Deleted Successfully');
        //
    }

    public function manage_individual_tickets($id){

        // $data = TicketsGenerated::where('event_tickets',$id)->get();

        $data = TicketsGenerated::with('outsideSell')->where('event_tickets', $id)->get();
    info($data);

        return view('admin.tickets.generated_ticket_list',compact('data'));

    }

    public function get_individual_ticketdata(Request $request, $ticketId)
    {

        $individualticketData = TicketsGenerated::with('eventTicket.ticketType','eventTicket.event.venue','eventTiming')->where('id', $ticketId)->first();
        info($individualticketData);
        return response()->json([
            'individualticketData' => $individualticketData,
        ]);

        // return view('admin.tickets.generated_ticket_list', compact('individualticketData'));
    }

    public function updateHoldStatus(Request $request)
    {

        // info("hloooo");
        info($request->all());
        $ticketId = $request->input('ticketId');
        $newHoldStatus = $request->input('newHoldStatus');
        $ticket = TicketsGenerated::find($ticketId);

        if ($ticket) {
            $newHoldStatus = ($newHoldStatus == 'Hold') ? '1' : '0';
            $ticket->under_purchase_hold = $newHoldStatus;
            $ticket->save();

            return response()->json(['success' => true, 'message' => 'Hold status updated successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Ticket not found.']);
        }

        // Update the database based on $ticketId and $newHoldStatus


    }

    public function outsidesell(Request $request)
    {
        $data = new OutsideSellModel();
        $data->event_ticket_tickets_id  = $request->event_ticket_tickets_id;
        $data->name = $request->name;
        $data->phone = $request->phone;
        $data->address = $request->address;
        $data->date = $request->date;
        $data->payment_mode = $request->payment_mode;

        $data->save();
        return redirect()->back();


    }

    public function get_outsidesell_data(Request $request, $outsidesell_id)
    {

        // return $outsidesell_id;

        $outsidesellData = OutsideSellModel::where('id', $outsidesell_id)->first();

        return response()->json([
            'outsidesellData' => $outsidesellData,
        ]);

        // return view('admin.tickets.generated_ticket_list', compact('individualticketData'));
    }

public function updateStatus(Request $request, $id)
{

    $ticket = EventTickets::find($id);

    if (!$ticket) {
        return response()->json([
            'success' => false,
            'message' => 'Ticket not found.',
        ], 404);
    }

    $ticket->ticket_status = ! $ticket->ticket_status;

    $ticket->save();

    return response()->json([
        'success' => true,
        'message' => 'Ticket status updated successfully.',
        'status'  => $ticket->ticket_status
    ]);
}

public function updatesaleStatus(Request $request, $id)
{

    $ticket = TicketsGenerated::find($id);

    if (!$ticket) {
        return response()->json([
            'success' => false,
            'message' => 'Ticket not found.',
        ], 404);
    }

    $ticket->on_sale = ! $ticket->on_sale;

    $ticket->save();

    return response()->json([
        'success' => true,
        'message' => 'Ticket status updated successfully.',
        'status'  => $ticket->on_sale
    ]);
}

public function get_ticket_data(Request $request){

    $id = $request->get('id');

    $ticket = TicketsGenerated::find($id);

       return response()->json([
        'success' => true,
        'data' =>  $ticket,

    ]);

}



}
