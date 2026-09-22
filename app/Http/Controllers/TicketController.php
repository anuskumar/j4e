<?php

namespace App\Http\Controllers;
use App\Models\User;

use App\Mail\TicketApprovedMail;
use App\Mail\TicketRejectedMail;
use App\Models\Events;
use App\Models\EventTickets;
use App\Models\EventTiming;
use App\Models\EventType;
use App\Models\LocationModel;
use App\Models\TicketsGenerated;
use App\Models\TicketType;
use App\Models\Currency;
use App\Models\OutsideSellModel;
use App\Models\RestrictionModel;
use App\Models\VenueModel;
use App\Models\VenueSeating;
use App\Models\TicketPurchase;
use App\Models\TicketStatus;
use App\Models\MobileApplication;
use App\Models\SplitTypeModel;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Emailj4eController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(Request $request)
    {
        $user = Auth::user();
        $isReseller = $user->user_type === 'reseller';

        $query = Events::query()
            ->leftJoin('event_type', 'event_type.id', 'event.event_type')
            ->leftJoin('users', 'users.id', 'event.event_added_by')
            ->leftJoin('venue', 'venue.id', 'event.venue')
            ->leftJoin('location', 'location.id', 'venue.location')
            ->leftJoin('countries', 'countries.id', 'location.country')
            ->leftJoin('cities', 'cities.id', 'location.city')
            ->select(
                'event.*',
                'event.id as id',
                'event.event_name as event_name',
                'event_type.event_type_name',
                'country_name',
                'cities.name as city_name',
                'location_name',
                'location.id as location_id',
                'venue.id as venue_id',
                'venue.name as venue_name',
                'event.created_at as created_at'
            )
            ->orderByDesc('event.id');

        if ($isReseller) {
            $query->whereExists(function ($subQuery) use ($user) {
                $subQuery->select(DB::raw(1))
                    ->from('event_tickets')
                    ->whereColumn('event_tickets.event', 'event.id')
                    ->where('event_tickets.created_by', $user->id)
                    ->whereNull('event_tickets.deleted_at');
            });
        }

        if ($request->filled('event_type')) {
            $query->where('event.event_type', $request->event_type);
        }

        if ($request->filled('location_id')) {
            $query->where('location.id', $request->location_id);
        }

        if ($request->filled('venue_id')) {
            $query->where('venue.id', $request->venue_id);
        }

        if ($request->filled('event_date_from')) {
            $query->whereDate('event.event_from_date', '>=', $request->event_date_from);
        }

        if ($request->filled('event_date_to')) {
            $query->where(function ($dateQuery) use ($request) {
                $dateQuery->whereDate('event.event_to_date', '<=', $request->event_date_to)
                    ->orWhere(function ($fallback) use ($request) {
                        $fallback->whereNull('event.event_to_date')
                            ->whereDate('event.event_from_date', '<=', $request->event_date_to);
                    });
            });
        }

        if ($request->filled('approval_status')) {
            if ($request->approval_status === 'pending') {
                $query->whereExists(function ($subQuery) {
                    $subQuery->select(DB::raw(1))
                        ->from('event_tickets')
                        ->whereColumn('event_tickets.event', 'event.id')
                        ->where('event_tickets.is_admin_approved', 0)
                        ->whereNull('event_tickets.deleted_at');
                });
            } elseif ($request->approval_status === 'approved') {
                $query->whereExists(function ($subQuery) {
                    $subQuery->select(DB::raw(1))
                        ->from('event_tickets')
                        ->whereColumn('event_tickets.event', 'event.id')
                        ->where('event_tickets.is_admin_approved', 1)
                        ->whereNull('event_tickets.deleted_at');
                });
            }
        }

        $data = $query->get();

        foreach ($data as $val) {
            $ticketQuery = EventTickets::where('event', $val->id);
            $val->waiting_for_approval = (clone $ticketQuery)->where('is_admin_approved', 0)->count();
            $val->my_tickets = (int) (clone $ticketQuery)->where('created_by', $user->id)->sum('no_of_tickets');
            $val->total_tickets = (int) (clone $ticketQuery)->sum('no_of_tickets');
        }

        $eventTypes = EventType::ordered()->get();

        $locations = LocationModel::leftJoin('countries', 'countries.id', 'location.country')
            ->leftJoin('cities', 'cities.id', 'location.city')
            ->select('location.id', 'location_name', 'cities.name as city_name', 'country_name')
            ->orderBy('location_name')
            ->get();

        $venuesQuery = VenueModel::leftJoin('location', 'location.id', 'venue.location')
            ->leftJoin('countries', 'countries.id', 'location.country')
            ->leftJoin('cities', 'cities.id', 'location.city')
            ->select('venue.id', 'venue.name as venue_name', 'location_name', 'cities.name as city_name', 'country_name', 'venue.location as location_id');

        if ($request->filled('location_id')) {
            $venuesQuery->where('venue.location', $request->location_id);
        }

        $venues = $venuesQuery->orderBy('venue.name')->get();

        $filters = [
            'event_type' => $request->event_type,
            'location_id' => $request->location_id,
            'venue_id' => $request->venue_id,
            'event_date_from' => $request->event_date_from,
            'event_date_to' => $request->event_date_to,
            'approval_status' => $request->approval_status,
        ];

        return view('admin.tickets.ticket_events', compact('data', 'eventTypes', 'locations', 'venues', 'filters', 'isReseller'));
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
    public function manage_tickets(Request $request, $id)
    {
        $user = Auth::user();
        $isReseller = $user->user_type === 'reseller';

        $event = Events::leftJoin('event_type', 'event_type.id', 'event.event_type')
            ->leftJoin('venue', 'venue.id', 'event.venue')
            ->leftJoin('location', 'location.id', 'venue.location')
            ->leftJoin('cities', 'cities.id', 'location.city')
            ->select(
                'event.*',
                'event.id as id',
                'event_type.event_type_name',
                'venue.name as venue_name',
                'location.location_name',
                'cities.name as city_name'
            )
            ->findOrFail($id);

        $data_all = EventTickets::leftjoin('ticket_type', 'ticket_type.id', 'event_tickets.ticket_type')
            ->leftjoin('event', 'event.id', 'event_tickets.event')
            ->leftjoin('venue', 'venue.id', 'event.venue')
            ->leftjoin('venue_seating', 'venue_seating.id', 'event_tickets.venue_seating')
            ->leftjoin('event_timings', 'event_timings.id', 'event_tickets.event_timing')
            ->leftjoin('users', 'users.id', 'event_tickets.created_by')
            ->leftjoin('currency', 'currency.id', 'event_tickets.amount_currency')
            ->leftjoin('ticket_status', 'ticket_status.id', 'event_tickets.ticket_status')
            ->where('event_tickets.event', $id);

        if ($user->user_type !== 'superadmin') {
            $data_all->where('event_tickets.created_by', $user->id);
        }

        if ($request->filled('approval_status')) {
            if ($request->approval_status === 'pending') {
                $data_all->where('event_tickets.is_admin_approved', 0);
            } elseif ($request->approval_status === 'approved') {
                $data_all->where('event_tickets.is_admin_approved', 1);
            } elseif ($request->approval_status === 'rejected') {
                $data_all->where('event_tickets.is_admin_approved', 2);
            }
        }

        if ($request->filled('ticket_type')) {
            $data_all->where('event_tickets.ticket_type', $request->ticket_type);
        }

        if ($request->filled('ticket_status')) {
            $data_all->where('event_tickets.ticket_status', $request->ticket_status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $data_all->where(function ($query) use ($search) {
                $query->where('event_tickets.ticket_name', 'like', '%' . $search . '%')
                    ->orWhere('users.name', 'like', '%' . $search . '%')
                    ->orWhere('users.email', 'like', '%' . $search . '%');
            });
        }

        $data = $data_all->select(
            'event_tickets.*',
            'event_tickets.id as id',
            'event_tickets.is_admin_approved as is_admin_approved',
            'ticket_type.ticket_type_name',
            'venue_seating.seating_type_name',
            'event_timings.event_date',
            'event_timings.from_time',
            'event_timings.to_time',
            'users.name as reseller_name',
            'users.email as reseller_email',
            'users.phone as reseller_phone',
            'currency.short_name as currency_short_name',
            'ticket_status.status_name as ticket_status_name'
        )->latest('event_tickets.created_at')->get();

        $selectedTicketTypeIds = [];
        if (!empty($event->ticket_types)) {
            $selectedTicketTypeIds = json_decode($event->ticket_types, true) ?: [];
        }
        if (!empty($selectedTicketTypeIds) && is_array($selectedTicketTypeIds)) {
            $ticket_type = TicketType::whereIn('id', $selectedTicketTypeIds)
                ->where('is_active', 1)
                ->get();
        } else {
            $ticket_type = TicketType::where('is_active', 1)->get();
        }

        $event_timing = EventTiming::where('event', $id)
            ->where('is_active', 1)
            ->orderBy('event_date')
            ->orderBy('from_time')
            ->get();
        $venue_seatings = VenueSeating::leftjoin('venue', 'venue.id', 'venue_seating.venue')
            ->where('venue.id', $event->venue)->select('*', 'venue_seating.id as id')->get();
        $currency = Currency::select('id', 'short_name', 'name', 'currency_rate', 'symbol', 'is_active')
            ->orderByRaw("CASE WHEN UPPER(short_name) = 'USD' THEN 0 ELSE 1 END")
            ->orderByDesc('is_active')
            ->orderBy('name')
            ->get();
        $restrictions = RestrictionModel::get();
        $splittypes = SplitTypeModel::select('split_name', 'id')->where('is_active', 1)->get();
        $mobile_applications = MobileApplication::where('is_active', 1)->orderBy('name')->get();
        $ticketStatuses = TicketStatus::where('is_active', 1)->orderBy('id')->get();

        $filters = [
            'approval_status' => $request->approval_status,
            'ticket_type' => $request->ticket_type,
            'ticket_status' => $request->ticket_status,
            'search' => $request->search,
        ];

        return view('admin.tickets.ticket_list', compact(
            'data',
            'id',
            'event',
            'ticket_type',
            'event_timing',
            'venue_seatings',
            'currency',
            'restrictions',
            'splittypes',
            'mobile_applications',
            'ticketStatuses',
            'filters',
            'isReseller'
        ));
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

       public function reject_tickets(Request $request)
       {
            $validated = $request->validate([
                'ticket_id' => 'required|numeric|exists:event_tickets,id',
                'rejection_reason' => 'required|string|min:5|max:2000',
            ]);

            $ticket = EventTickets::find($validated['ticket_id']);
            if (!$ticket) {
                return Response::json([
                    'status' => false,
                    'message' => 'Ticket not found.',
                ]);
            }

            $reason = trim($validated['rejection_reason']);
            $ticket->is_admin_approved = 2;
            $ticket->ticket_status = EventTickets::STATUS_UNAPPROVED;
            $ticket->rejection_reason = $reason;
            $ticket->save();

            $user = User::find($ticket->created_by);
            $event = Events::find($ticket->event);

            try {
                if ($user && $user->email && $event) {
                    Mail::to($user->email)->send(new TicketRejectedMail(
                        $user->name,
                        $event->event_name,
                        $event->event_from_date,
                        $ticket->ticket_name,
                        $reason
                    ));
                }
            } catch (\Exception $e) {
                Log::error('Failed to send rejection email: ' . $e->getMessage(), [
                    'ticket_id' => $ticket->id,
                    'error' => $e->getMessage(),
                ]);
            }

            try {
                app(NotificationService::class)->notifyTicketRejected($ticket, $reason, $user);
            } catch (\Exception $e) {
                Log::error('Failed to create rejection notification: ' . $e->getMessage(), [
                    'ticket_id' => $ticket->id,
                    'error' => $e->getMessage(),
                ]);
            }

            return Response::json([
                'status' => true,
                'message' => 'Ticket rejected. Reseller has been notified.',
            ]);
       }

     public function approve_tickets(Request $request){
        try {
            $validated = $request->validate([
                'ticket_id' => 'required|numeric',
            ]);
            
            $id = $request->ticket_id;
            
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
            
            $user = User::where('id', $ticket->created_by)->first();
            if (!$user) {
                DB::rollBack();
                return Response::json([
                    'status' => false,
                    'message' => 'User not found.'
                ]);
            }
            
            $seating = $ticket->venue_seating
                ? VenueSeating::find($ticket->venue_seating)
                : null;
            
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
                $ticket->ticket_status = EventTickets::STATUS_ACTIVE;
                $ticket->rejection_reason = null;
                $ticket->save();
                DB::commit();

                // Send approval email
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
                    Log::error('Failed to send approval email: ' . $e->getMessage(), [
                        'ticket_id' => $id,
                        'user_email' => $user->email ?? 'unknown',
                        'error' => $e->getMessage()
                    ]);
                }

                try {
                    app(NotificationService::class)->notifyTicketApproved($ticket, $user);
                } catch (\Exception $e) {
                    Log::error('Failed to create approval notification: ' . $e->getMessage(), [
                        'ticket_id' => $id,
                        'error' => $e->getMessage(),
                    ]);
                }
                
                return Response::json([
                    'status' => true,
                    'message' => 'Ticket approved successfully.'
                ]);
            }
            
            // Generate individual tickets without requiring row/seat details.
            // Prefer seat_from/seat_to when present; otherwise use no_of_tickets.
            $seatPrefix = optional($seating)->seat_serial_prefix ?? 'T';
            $seatRow = $ticket->row !== null && $ticket->row !== '' ? $ticket->row : null;

            if ($ticket->seat_from !== null && $ticket->seat_from !== ''
                && $ticket->seat_to !== null && $ticket->seat_to !== '') {
                $seatFrom = (int) $ticket->seat_from;
                $seatTo = (int) $ticket->seat_to;
                if ($seatTo < $seatFrom) {
                    [$seatFrom, $seatTo] = [$seatTo, $seatFrom];
                }
            } else {
                $ticketCount = max(1, (int) $ticket->no_of_tickets);
                $seatFrom = 1;
                $seatTo = $ticketCount;
            }

            for ($i = $seatFrom; $i <= $seatTo; $i++) {
                $rowPart = $seatRow !== null ? $seatRow : 'NA';
                $new_generate = new TicketsGenerated();
                $new_generate->event_tickets = $id;
                $new_generate->ticket_serial_number = $seatPrefix . $i . '-' . $rowPart . '-' . time() . '-' . $i;
                $new_generate->is_sold = 0;
                $new_generate->under_purchase_hold = 0;
                $new_generate->ticket_amount = $ticket->ticket_amount;
                $new_generate->seat_number = $i;
                $new_generate->seat_row = $seatRow;
                $new_generate->seat_prefix = $seatPrefix;
                $new_generate->seat_number_prefix = $seatPrefix . '-' . $rowPart . '-' . $i;
                $new_generate->event_timing = $ticket->event_timing;
                $new_generate->event_seating = $ticket->venue_seating;
                $new_generate->event_id = $ticket->event;
                $new_generate->save();
            }
            
            // Update ticket approval status
            $ticket->is_admin_approved = 1;
            $ticket->ticket_status = EventTickets::STATUS_ACTIVE;
            $ticket->rejection_reason = null;
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

            try {
                app(NotificationService::class)->notifyTicketApproved($ticket, $user);
            } catch (\Exception $e) {
                Log::error('Failed to create approval notification: ' . $e->getMessage(), [
                    'ticket_id' => $id,
                    'error' => $e->getMessage(),
                ]);
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
        $isCreate = $request->post('event_id') == '';

        if ($isCreate) {
            $rules = [
                'event' => 'required|numeric',
                'ticket_name' => 'required',
                'event_timing' => 'required|numeric',
                'no_of_tickets' => 'required|numeric|min:1',
                'ticket_amount' => 'required|numeric|min:0',
                'cents' => 'nullable|numeric|min:0|max:99',
                'face_value' => 'nullable|numeric|min:0',
                'amount_currency' => 'required|numeric',
                'ticket_type' => 'required|exists:ticket_type,id',
                'venue_seating' => 'required|numeric',
                'sell_together' => 'required|numeric',
                'row' => 'nullable|string|max:50',
                'seat_from' => 'nullable|numeric',
                'seat_to' => 'nullable|numeric',
                'mobile_app' => [
                    'nullable',
                    Rule::exists('mobile_applications', 'id')->where('is_active', 1),
                ],
                'ticket_restrictions' => 'nullable|array',
            ];

            $ticketType = TicketType::find($request->ticket_type);
            $isMobileTransfer = $ticketType && (
                (int) $ticketType->id === 4
                || (
                    stripos($ticketType->ticket_type_name, 'mobile') !== false
                    && stripos($ticketType->ticket_type_name, 'transfer') !== false
                )
            );

            if ($isMobileTransfer) {
                $rules['mobile_app'] = [
                    'required',
                    Rule::exists('mobile_applications', 'id')->where('is_active', 1),
                ];
            }

            $request->validate($rules);
            $data = new EventTickets;
            $data->unique_id = Str::random(16);
        } else {
            $data = EventTickets::find($request->post('event_id'));
            info($data);
        }

        $cents = (float) ($request->cents ?? 0);
        $ticketAmount = (float) $request->ticket_amount + ($cents / 100);
        $faceValue = $request->filled('face_value')
            ? (float) $request->face_value
            : $ticketAmount;

        $data->ticket_name = $request->ticket_name;
        $data->ticket_type = $request->ticket_type;
        $data->event = $request->event;
        $data->event_timing = $request->event_timing;
        $data->no_of_tickets = $request->no_of_tickets;
        $data->booking_expiry_date_time = $request->booking_expiry_date_time;
        $data->venue_seating = $request->venue_seating;
        $data->ticket_amount = $ticketAmount;
        $data->amount_currency = $request->amount_currency;
        $data->cancellation_policy_notes = $request->cancellation_policy_notes;
        $data->disclaimer_note = $request->disclaimer_note;
        $data->row = $request->row;
        $data->seat_from = $request->seat_from;
        $data->seat_to = $request->seat_to;
        $data->face_value = $faceValue;
        $data->split_type = $request->sell_together ?: $data->split_type;

        $qty = max(1, (int) $request->no_of_tickets);
        $sellerFeePercent = (float) optional(Events::find($request->event))->seller_fee_percent;
        $sellerFeePercent = $sellerFeePercent > 0 ? $sellerFeePercent : 10;
        $listingTotal = round($ticketAmount * $qty, 2);
        $sellerFee = round(($listingTotal * $sellerFeePercent) / 100, 2);
        $receivePerTicket = round($ticketAmount * (100 - $sellerFeePercent) / 100, 2);
        $totalReceive = round($listingTotal - $sellerFee, 2);

        // web_price is used as the public per-ticket listing price (same as ticket_amount).
        $data->web_price = $ticketAmount;
        $data->seller_fee = $sellerFee;
        $data->recive_perticket = $receivePerTicket;
        $data->total_recive = $totalReceive;

        if ($isCreate || $request->has('ticket_restrictions')) {
            $data->ticket_restrictions = json_encode($request->ticket_restrictions ?? []);
        }

        $features = [];
        foreach (['clearView', 'limitedView', 'vipPass', 'mealPackage', 'parking', 'standingOnly', 'aisleSeat'] as $field) {
            if ($request->has($field)) {
                $features[] = $field;
            }
        }
        if (in_array('clearView', $features, true) && in_array('limitedView', $features, true)) {
            $features = array_values(array_filter($features, fn ($feature) => $feature !== 'limitedView'));
        }
        if ($isCreate || $request->hasAny(['clearView', 'limitedView', 'vipPass', 'mealPackage', 'parking', 'standingOnly', 'aisleSeat', 'features_submitted'])) {
            $data->features = json_encode(['features' => $features]);
        }

        if ($request->filled('mobile_app')) {
            $data->mobile_application_id = $request->mobile_app;
        } elseif ($isCreate) {
            $data->mobile_application_id = null;
        }

        if ($request->hasFile('image')) {
            $currentImagePath = storage_path('uploads/ticket_images') . '/' . $data->image;

            if (is_file($currentImagePath)) {
                unlink($currentImagePath);
            }
            $imageName = rand() . '.' . $request->image->extension();
            $request->image->move(storage_path('uploads/ticket_images'), $imageName);
            $data->image = $imageName;
        }

        if ($request->hasFile('ticket_upload')) {
            $currentImagePath = storage_path('uploads/ticket_images') . '/' . $data->ticket_upload;

            if (is_file($currentImagePath)) {
                unlink($currentImagePath);
            }
            $imageName = rand() . '.' . $request->ticket_upload->extension();
            $request->ticket_upload->move(storage_path('uploads/ticket_images'), $imageName);
            $data->ticket_upload = $imageName;
        }

        $data->is_admin_approved = 0;
        $data->ticket_status = EventTickets::STATUS_UNAPPROVED;
        $data->created_by = Auth::user()->id;
        $data->save();

        if ($isCreate) {
            app(NotificationService::class)->notifyTicketCreated($data);
        }

        if ($request->post('event_id')) {
            return back()->with('success', 'Ticket Updated successfully');
        }

        return back()->with('success', 'Ticket Created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = EventTickets::query()
            ->leftJoin('ticket_type', 'ticket_type.id', 'event_tickets.ticket_type')
            ->leftJoin('event', 'event.id', 'event_tickets.event')
            ->leftJoin('venue', 'venue.id', 'event.venue')
            ->leftJoin('location', 'location.id', 'venue.location')
            ->leftJoin('cities', 'cities.id', 'location.city')
            ->leftJoin('venue_seating', 'venue_seating.id', 'event_tickets.venue_seating')
            ->leftJoin('event_timings', 'event_timings.id', 'event_tickets.event_timing')
            ->leftJoin('ticket_status', 'ticket_status.id', 'event_tickets.ticket_status')
            ->leftJoin('currency', 'currency.id', 'event_tickets.amount_currency')
            ->leftJoin('users', 'users.id', 'event_tickets.created_by')
            ->leftJoin('split_types', 'split_types.id', 'event_tickets.split_type')
            ->where('event_tickets.id', $id)
            ->select(
                'event_tickets.*',
                'event_tickets.id as id',
                'ticket_type.ticket_type_name',
                'event.event_name',
                'event.event_image',
                'event.event_from_date',
                'event.event_to_date',
                'venue.name as venue_name',
                'location.location_name',
                'cities.name as city_name',
                'venue_seating.seating_type_name',
                'event_timings.event_date',
                'event_timings.from_time',
                'event_timings.to_time',
                'ticket_status.status_name as ticket_status_name',
                'currency.short_name as currency_short_name',
                'currency.name as currency_name',
                'users.name as reseller_name',
                'users.email as reseller_email',
                'users.phone as reseller_phone',
                'split_types.split_name as split_type_name'
            )
            ->firstOrFail();

        $restrictionIds = $data->ticket_restrictions ? json_decode($data->ticket_restrictions, true) : [];
        $restrictionNames = is_array($restrictionIds) && $restrictionIds
            ? RestrictionModel::whereIn('id', $restrictionIds)->pluck('restrictions')->implode(', ')
            : '';

        return view('admin.tickets.ticket_view', compact('data', 'restrictionNames'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function ticket_edit(string $id)
    {
        $data = EventTickets::
        leftjoin('ticket_type','ticket_type.id','event_tickets.ticket_type')
        ->leftjoin('event','event.id','event_tickets.event')
        ->leftjoin('venue','venue.id','event.venue')
        ->leftjoin('venue_seating','venue_seating.id','event_tickets.venue_seating')
        ->leftjoin('event_timings','event_timings.id','event_tickets.event_timing')
        ->leftjoin('ticket_status','ticket_status.id','event_tickets.ticket_status')
        ->where('event_tickets.id',$id)
        ->select('*','event_tickets.id as id', 'event_tickets.event as event')->first();

        $event = Events::find($data->event);
        $selectedTicketTypeIds = [];
        if (!empty($event->ticket_types)) {
            $selectedTicketTypeIds = json_decode($event->ticket_types, true) ?: [];
        }
        if (!empty($selectedTicketTypeIds) && is_array($selectedTicketTypeIds)) {
            $ticket_type = TicketType::whereIn('id', $selectedTicketTypeIds)->where('is_active', 1)->get();
        } else {
            $ticket_type = TicketType::where('is_active', 1)->get();
        }

        $event_timing = EventTiming::where('event', $data->event)->where('is_active', 1)->orderBy('event_date')->orderBy('from_time')->get();

        $venue_seatings = VenueSeating::leftjoin('venue','venue.id','venue_seating.venue')
        ->where('venue.id',$data->venue)->select('*','venue_seating.id as id')->get();
        $currency = Currency::select('id', 'short_name', 'name', 'currency_rate', 'symbol', 'is_active')
            ->orderByRaw("CASE WHEN UPPER(short_name) = 'USD' THEN 0 ELSE 1 END")
            ->orderByDesc('is_active')
            ->orderBy('name')
            ->get();
        $restrictions = RestrictionModel::get();
        $splittypes = SplitTypeModel::select('split_name', 'id')->where('is_active', 1)->get();
        $mobile_applications = MobileApplication::where('is_active', 1)->orderBy('name')->get();
        $selectedFeatures = [];
        if (!empty($data->features)) {
            $decoded = json_decode($data->features, true);
            $selectedFeatures = $decoded['features'] ?? [];
        }

        return view('admin.tickets.ticket_edit', compact(
            'data',
            'ticket_type',
            'event_timing',
            'venue_seatings',
            'currency',
            'restrictions',
            'splittypes',
            'mobile_applications',
            'selectedFeatures'
        ));
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

    public function manage_individual_tickets(Request $request, $id)
    {
        $eventTicket = EventTickets::leftJoin('event', 'event.id', 'event_tickets.event')
            ->leftJoin('currency', 'currency.id', 'event_tickets.amount_currency')
            ->leftJoin('venue_seating', 'venue_seating.id', 'event_tickets.venue_seating')
            ->where('event_tickets.id', $id)
            ->select(
                'event_tickets.*',
                'event_tickets.id as id',
                'event.event_name',
                'currency.short_name as currency_short_name',
                'venue_seating.seating_type_name'
            )
            ->firstOrFail();

        $query = TicketsGenerated::with('outsideSell')->where('event_tickets', $id);

        if ($request->filled('sold_status')) {
            if ($request->sold_status === 'sold') {
                $query->where('is_sold', 1);
            } elseif ($request->sold_status === 'unsold') {
                $query->where('is_sold', 0);
            }
        }

        if ($request->filled('hold_status')) {
            if ($request->hold_status === 'hold') {
                $query->where('under_purchase_hold', 1);
            } elseif ($request->hold_status === 'no_hold') {
                $query->where('under_purchase_hold', 0);
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('seat_number_prefix', 'like', '%' . $search . '%')
                    ->orWhere('seat_id', 'like', '%' . $search . '%')
                    ->orWhere('seat_row', 'like', '%' . $search . '%')
                    ->orWhere('seat_number', 'like', '%' . $search . '%');
            });
        }

        $data = $query->orderBy('id')->get();

        $filters = [
            'sold_status' => $request->sold_status,
            'hold_status' => $request->hold_status,
            'search' => $request->search,
        ];

        $ticketTypes = TicketType::where('is_active', 1)->orderBy('ticket_type_name')->get();

        return view('admin.tickets.generated_ticket_list', compact('data', 'eventTicket', 'filters', 'ticketTypes'));
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

        $individualticketData = TicketsGenerated::with(
            'eventTicket.ticketType',
            'eventTicket.event.venue',
            'eventTicket.seating',
            'eventTiming'
        )->where('id', $ticketId)->first();
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
        $validated = $request->validate([
            'event_ticket_tickets_id' => 'required|exists:event_ticket_tickets,id',
            'ticket_type_id' => 'required|exists:ticket_type,id',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'date' => 'nullable|date',
            'payment_mode' => 'required|string|max:100',
            'cost_price' => 'nullable|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
            'remark' => 'nullable|string',
        ]);

        $generated = TicketsGenerated::findOrFail($validated['event_ticket_tickets_id']);
        $costPrice = $request->filled('cost_price')
            ? (float) $request->cost_price
            : (float) ($generated->ticket_amount ?? 0);

        $data = new OutsideSellModel();
        $data->event_ticket_tickets_id = $validated['event_ticket_tickets_id'];
        $data->ticket_type_id = $validated['ticket_type_id'];
        $data->name = $validated['name'];
        $data->phone = $request->phone;
        $data->email = $request->email;
        $data->address = $request->address;
        $data->date = $request->date;
        $data->payment_mode = $validated['payment_mode'];
        $data->cost_price = $costPrice;
        $data->sale_price = $validated['sale_price'];
        $data->remark = $request->remark;
        $data->save();

        $generated->is_sold = 1;
        $generated->fulfillment_status = TicketsGenerated::FULFILLMENT_SOLD;
        $generated->on_sale = 0;
        $generated->ticket_amount = $validated['sale_price'];
        $generated->under_purchase_hold = 0;
        $generated->save();

        EventTickets::markSoldAfterFulfillment((int) $generated->event_tickets);

        return redirect()->back()->with('success', 'Outside sell saved successfully.');
    }

    public function get_outsidesell_data(Request $request, $outsidesell_id)
    {
        $outsidesellData = OutsideSellModel::with('ticketType')->where('id', $outsidesell_id)->first();

        return response()->json([
            'outsidesellData' => $outsidesellData,
            'ticket_type_name' => optional($outsidesellData?->ticketType)->ticket_type_name,
            'proof_urls' => $outsidesellData ? $outsidesellData->proof_urls : [],
        ]);
    }

    public function uploadOutsideSellProof(Request $request)
    {
        $validated = $request->validate([
            'outsidesell_id' => 'required|exists:outsidesell,id',
            'proof_files' => 'required|array|min:1',
            'proof_files.*' => 'file|mimes:jpg,jpeg,png,pdf,webp|max:5120',
        ]);

        $sale = OutsideSellModel::findOrFail($validated['outsidesell_id']);
        $uploadDir = storage_path('uploads/outside_sell_proof');
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $existing = $sale->proof_files_list;
        $uploaded = [];

        foreach ($request->file('proof_files', []) as $file) {
            if (!$file) {
                continue;
            }
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $fileName);
            $existing[] = $fileName;
            $uploaded[] = $fileName;
        }

        $sale->proof_file = array_values(array_unique($existing));
        $sale->save();

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => count($uploaded) . ' proof file(s) uploaded successfully.',
                'proof_files' => $sale->proof_files_list,
                'proof_urls' => $sale->proof_urls,
            ]);
        }

        return redirect()->back()->with('success', 'Proof file(s) uploaded successfully.');
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

    if (! $ticket->canToggleActivePaused()) {
        return response()->json([
            'success' => false,
            'message' => 'Only Active or Paused listings can be toggled.',
        ], 422);
    }

    $ticket->ticket_status = (int) $ticket->ticket_status === EventTickets::STATUS_ACTIVE
        ? EventTickets::STATUS_PAUSED
        : EventTickets::STATUS_ACTIVE;

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

    $listing = EventTickets::find($ticket->event_tickets);
    if (!$listing || (int) $listing->created_by !== (int) Auth::id()) {
        return response()->json([
            'success' => false,
            'message' => 'Unauthorized access.',
        ], 403);
    }

    if (!empty($ticket->is_sold)) {
        return response()->json([
            'success' => false,
            'message' => 'Sold tickets cannot be updated.',
        ], 422);
    }

    $sequence = TicketsGenerated::where('event_tickets', $ticket->event_tickets)
        ->orderByRaw('CAST(seat_number AS UNSIGNED) ASC')
        ->orderBy('id')
        ->get();

    $firstTicket = $sequence->first();
    $lastTicket = $sequence->last();
    $isFirst = $firstTicket && (int) $firstTicket->id === (int) $ticket->id;
    $isLast = $lastTicket && (int) $lastTicket->id === (int) $ticket->id;

    if (!$isFirst && !$isLast) {
        return response()->json([
            'success' => false,
            'message' => 'This ticket cannot be updated because the continuation of the seat sequence will be lost. You can only change On Sale for the first or last ticket in the sequence.',
        ], 422);
    }

    if ($request->has('status')) {
        $ticket->on_sale = ((int) $request->input('status') === 1) ? 1 : 0;
    } else {
        $ticket->on_sale = $ticket->on_sale ? 0 : 1;
    }

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
