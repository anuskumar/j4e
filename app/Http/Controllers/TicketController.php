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
use App\Models\TicketPurchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Emailj4eController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        try {
            $validated = $request->validate([
                'ticket_id' => 'required|numeric',
            ]);
            
            $id = $request->ticket_id;
            $user_id = $request->created_by;
            
            // Start database transaction
            DB::beginTransaction();
            
            $ticket = EventTickets::find($id);
            if (!$ticket) {
                DB::rollBack();
                return Response::json([
                    'status' => false,
                    'message' => 'Ticket not found.'
                ]);
            }
            
            $user = User::where('id', $user_id)->first();
            if (!$user) {
                DB::rollBack();
                return Response::json([
                    'status' => false,
                    'message' => 'User not found.'
                ]);
            }
            
            $seating = VenueSeating::find($ticket->venue_seating);
            if (!$seating) {
                DB::rollBack();
                return Response::json([
                    'status' => false,
                    'message' => 'Cannot Approve: Venue seating has some issues. Please check that.'
                ]);
            }
            
            $event = Events::where('id', $ticket->event)->first();
            if (!$event) {
                DB::rollBack();
                return Response::json([
                    'status' => false,
                    'message' => 'Event not found.'
                ]);
            }
            
            // Check if ticket already has TicketsGenerated records (already approved)
            $existingTickets = TicketsGenerated::where('event_tickets', $id)->count();
            if ($existingTickets > 0) {
                // Ticket already has generated tickets, just update approval status
                $ticket->is_admin_approved = 1;
                $ticket->save();
                DB::commit();
                
                return Response::json([
                    'status' => true,
                    'message' => 'Ticket approved successfully.'
                ]);
            }
            
            // Check if seat information is available
            if (!$ticket->seat_from || !$ticket->seat_to || !$ticket->row) {
                DB::rollBack();
                return Response::json([
                    'status' => false,
                    'message' => 'Cannot Approve: Seat information is missing. Please check seat details.'
                ]);
            }
            
            // Generate tickets for each seat
            $seatFrom = (int)$ticket->seat_from;
            $seatTo = (int)$ticket->seat_to;
            $seatPrefix = $seating->seat_serial_prefix ?? 'T';
            
            for ($i = $seatFrom; $i <= $seatTo; $i++) {
                $new_generate = new TicketsGenerated();
                $new_generate->event_tickets = $id;
                $new_generate->ticket_serial_number = $seatPrefix . $i . '-' . $ticket->row . '-' . time() . '-' . $i;
                $new_generate->is_sold = 0;
                $new_generate->under_purchase_hold = 0;
                $new_generate->ticket_amount = $ticket->ticket_amount;
                $new_generate->seat_number = $i;
                $new_generate->seat_row = $ticket->row;
                $new_generate->seat_prefix = $seatPrefix;
                $new_generate->seat_number_prefix = $seatPrefix . '-' . $ticket->row . '-' . $i;
                $new_generate->event_timing = $ticket->event_timing;
                $new_generate->event_seating = $ticket->venue_seating;
                $new_generate->event_id = $ticket->event;
                $new_generate->save();
            }
            
            // Update ticket approval status
            $ticket->is_admin_approved = 1;
            $ticket->save();
            
            // Commit transaction
            DB::commit();
            
            // Send approval email (outside transaction) - don't let email errors affect approval
            try {
                $count = TicketsGenerated::where('event_tickets', $id)->count();
                $maildata = [
                    'email' => $user->email,
                    'resellername' => $user->name,
                    'eventname' => $event->event_name,
                    'eventdate' => $event->event_from_date,
                    'numberoftickets' => $count,
                    'totalamount' => $ticket->ticket_amount
                ];
                
                $emailController = new Emailj4eController();
                $emailController->ticketapprovedmail($maildata);
            } catch (\Exception $e) {
                // Log email error but don't fail the approval
                Log::error('Failed to send approval email: ' . $e->getMessage(), [
                    'ticket_id' => $id,
                    'user_email' => $user->email ?? 'unknown',
                    'error' => $e->getMessage()
                ]);
                // Continue - approval was successful even if email failed
            }
            
            return Response::json([
                'status' => true,
                'message' => 'Ticket approved successfully!'
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return Response::json([
                'status' => false,
                'message' => 'Validation error: ' . implode(', ', $e->errors()['ticket_id'] ?? ['Invalid ticket ID'])
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Ticket approval error: ' . $e->getMessage(), [
                'ticket_id' => $request->ticket_id,
                'trace' => $e->getTraceAsString()
            ]);
            
            return Response::json([
                'status' => false,
                'message' => 'An error occurred while approving the ticket: ' . $e->getMessage()
            ]);
        }
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
        
        // Get the main event ticket to show/update ticket price
        $eventTicket = EventTickets::find($id);
        
        return view('admin.tickets.generated_ticket_list', compact('data', 'eventTicket'));

    }
    
    public function updateTicketPrice(Request $request, $id)
    {
        try {
            // Check if user is admin
            if (Auth::user()->user_type != 'superadmin') {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized. Only admin can update ticket price.'
                ], 403);
            }

            $validated = $request->validate([
                'ticket_amount' => 'required|numeric|min:0',
            ]);

            $eventTicket = EventTickets::find($id);
            
            if (!$eventTicket) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ticket not found.'
                ], 404);
            }

            $oldAmount = $eventTicket->ticket_amount;
            $eventTicket->ticket_amount = $validated['ticket_amount'];
            $eventTicket->save();
            
            // Update ALL generated tickets (both sold and unsold) with the new amount
            // Use DB facade to ensure update works even if ticket_amount is not in fillable
            $updatedCount = DB::table('event_ticket_tickets')
                ->where('event_tickets', $id)
                ->update(['ticket_amount' => $validated['ticket_amount']]);

            return response()->json([
                'success' => true,
                'message' => 'Ticket price updated successfully. ' . $updatedCount . ' ticket(s) updated.',
                'data' => [
                    'old_amount' => $oldAmount,
                    'new_amount' => $eventTicket->ticket_amount,
                    'updated_count' => $updatedCount
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error: ' . implode(', ', $e->errors()['ticket_amount'] ?? ['Invalid amount'])
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error updating ticket price: ' . $e->getMessage(), [
                'ticket_id' => $id,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the ticket price: ' . $e->getMessage()
            ], 500);
        }
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

public function transactionHistory($id)
{
    // Get event details
    $event = Events::find($id);
    
    if (!$event) {
        return redirect()->back()->with('error', 'Event not found');
    }

    // Get all ticket purchases for this event
    $transactions_query = TicketPurchase::where('ticket_purchase.event_id', $id)
        ->leftjoin('event_tickets', 'event_tickets.id', 'ticket_purchase.event_ticket_id')
        ->leftjoin('users', 'users.id', 'ticket_purchase.user_id')
        ->leftjoin('currency', 'currency.id', 'ticket_purchase.payment_currency')
        ->leftjoin('purchase_status', 'purchase_status.id', 'ticket_purchase.purchase_status')
        ->leftjoin('countries', 'countries.id', 'ticket_purchase.shipping_country')
        ->select(
            'ticket_purchase.*',
            'ticket_purchase.id as purchase_id',
            'event_tickets.ticket_name',
            'event_tickets.ticket_amount',
            'event_tickets.created_by as ticket_created_by',
            'users.name as user_name',
            'users.email as user_email',
            'currency.name as currency_name',
            'currency.short_name as currency_short',
            'purchase_status.status_name',
            'countries.country_name'
        );

    // Filter based on user type - similar to OrderController
    if(Auth::user()->user_type != 'superadmin') {
        $transactions_query->where('event_tickets.created_by', Auth::user()->id);
    }

    $transactions = $transactions_query->orderBy('ticket_purchase.created_at', 'DESC')->get();

    // Get ticket counts for each purchase
    foreach ($transactions as $transaction) {
        $transaction->ticket_count = TicketsGenerated::where('purchase_id', $transaction->purchase_id)->count();
        $transaction->ticket_details = TicketsGenerated::where('purchase_id', $transaction->purchase_id)
            ->leftjoin('event_timings', 'event_timings.id', 'event_ticket_tickets.event_timing')
            ->select('event_ticket_tickets.*', 'event_timings.event_date', 'event_timings.from_time', 'event_timings.to_time')
            ->get();
    }

    return view('admin.tickets.transaction_history', compact('event', 'transactions'));
}

}
