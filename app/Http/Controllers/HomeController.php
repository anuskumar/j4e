<?php

namespace App\Http\Controllers;

use App\Models\TicketPurchase;
use App\Models\Events;
use App\Models\OutsideSellModel;
use App\Models\User;
use App\Models\TicketsGenerated;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Redirect to appropriate home based on user type
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToRoleHome()
    {
        $userType = Auth::user()->user_type;
        
        if ($userType === 'superadmin') {
            return redirect()->route('admin.home');
        } elseif ($userType === 'customer') {
            if (! Auth::user()->hasVerifiedEmail()) {
                return redirect()->route('verification.notice')
                    ->withErrors(['email' => "Your email doesn't verified"])
                    ->with('unverified_email', Auth::user()->email);
            }
            return redirect()->route('customer.home');
        } elseif ($userType === 'reseller') {
            return redirect()->route('reseller.home');
        }
        
        return redirect()->route('login');
    }

    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function adminHome()
    {
        $invoice_complete_count = TicketPurchase::where('purchase_status','6')->count();
        $process_count=TicketPurchase::where('purchase_status','2')->count();
        $reseller_count=User::where('user_type','reseller')->count();
        $user_count=User::where('user_type','customer')->count();
        $outside_hold_count=TicketsGenerated::where('under_purchase_hold','1')->count();
        $outside_sell_count=OutsideSellModel::count();
        $sold_ticket_sum=TicketsGenerated::where('is_sold','1')->sum('ticket_amount');
        $current_date = now()->toDateString();
        $upcoming_events = Events::leftjoin('event_type','event_type.id','event.event_type')
                        ->leftjoin('users','users.id','event.event_added_by')
                        ->leftjoin('venue','venue.id','event.venue')->
                        leftjoin('location','location.id','venue.location')
                        ->leftjoin('countries','countries.id','location.country')
                        ->leftjoin('cities','cities.id','location.city')

                      ->select(
                          '*',
                          'event.id as id',
                          'country_name',
                          'cities.name as city_name',
                          'location_name',
                          'venue.name as venue_name',
                          DB::raw('(SELECT COUNT(*) FROM event_ticket_tickets WHERE event_id = event.id) as total_ticket_count'),
                          DB::raw('(SELECT COUNT(*) FROM event_ticket_tickets WHERE event_id = event.id AND is_sold = 1) as sold_ticket_count')
                      )
                      ->where('event.event_from_date', '>=', $current_date)
                       ->get();

        return view('admin.home.dashboard', compact(
            'invoice_complete_count',
            'process_count',
            'reseller_count',
            'user_count',
            'outside_hold_count',
            'outside_sell_count',
            'sold_ticket_sum',
            'upcoming_events'
        ));
    }

    /**
     * Show the customer dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function customerHome()
    {
        $last_booking = TicketPurchase::leftjoin('event','event.id','ticket_purchase.event_id')
        ->leftjoin('event_tickets','event_tickets.id','ticket_purchase.event_ticket_id')
        ->leftjoin('event_tags','event_tags.id','event.event_tag')
        ->leftjoin('event_type','event_type.id','event.event_type')
        ->select('*','ticket_purchase.id as id')->
        where('user_id',Auth::user()->id)->latest('ticket_purchase.created_at')
        ->take(5)->get();

        foreach($last_booking as $book){
          $book['event_date'] =   TicketsGenerated::leftjoin('event_timings','event_timings.id','event_ticket_tickets.event_timing')->where('purchase_id',$book->id)->first();
        }

        $all_bookings = TicketPurchase::leftjoin('event','event.id','ticket_purchase.event_id')
        ->leftjoin('event_tickets','event_tickets.id','ticket_purchase.event_ticket_id')
        ->leftjoin('event_tags','event_tags.id','event.event_tag')
        ->leftjoin('event_type','event_type.id','event.event_type')
        ->leftjoin('currency','currency.id','ticket_purchase.payment_currency')
        ->leftjoin('purchase_status','purchase_status.id','ticket_purchase.purchase_status')

        ->select('*','ticket_purchase.id as id')->
        where('user_id',Auth::user()->id)->latest('ticket_purchase.created_at')
        ->get();

        foreach($all_bookings as $book){
            $book['event_date'] =   TicketsGenerated::leftjoin('event_timings','event_timings.id','event_ticket_tickets.event_timing')->where('purchase_id',$book->id)->first();
            // Get all tickets with full details for this purchase
            $book['tickets'] = TicketsGenerated::where('purchase_id', $book->id)
                ->leftjoin('event_tickets', 'event_tickets.id', 'event_ticket_tickets.event_tickets')
                ->leftjoin('event_timings', 'event_timings.id', 'event_ticket_tickets.event_timing')
                ->leftjoin('venue_seating', 'venue_seating.id', 'event_ticket_tickets.event_seating')
                ->leftjoin('event', 'event.id', 'event_ticket_tickets.event_id')
                ->select(
                    'event_ticket_tickets.id',
                    'event_ticket_tickets.file',
                    'event_ticket_tickets.ticket_serial_number',
                    'event_ticket_tickets.seat_number',
                    'event_ticket_tickets.seat_row',
                    'event_ticket_tickets.ticket_amount',
                    'event_tickets.ticket_name',
                    'event_tickets.ticket_type',
                    'event_timings.event_date',
                    'event_timings.from_time',
                    'event_timings.to_time',
                    'venue_seating.seating_type_name',
                    'event.event_name'
                )
                ->get();
        }

        $upcomming_booking = TicketPurchase::leftjoin('event','event.id','ticket_purchase.event_id')
          ->leftjoin('event_tickets','event_tickets.id','ticket_purchase.event_ticket_id')
          ->leftjoin('event_tags','event_tags.id','event.event_tag')
          ->leftjoin('event_type','event_type.id','event.event_type')
          ->leftjoin('currency','currency.id','ticket_purchase.payment_currency')
          ->select('*','ticket_purchase.id as id')->
          where('user_id',Auth::user()->id)->latest('ticket_purchase.created_at')
          ->whereDate('event_from_date','>',Carbon::now())
          ->get();
          
        foreach($upcomming_booking as $book){
            $book['event_date'] =   TicketsGenerated::leftjoin('event_timings','event_timings.id','event_ticket_tickets.event_timing')->where('purchase_id',$book->id)->first();
        }

        return view('customer-profile',compact('last_booking','all_bookings','upcomming_booking'));
    }

    /**
     * Show ticket details page for a purchase.
     *
     * @param int $id Purchase ID
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function ticketDetails($id)
    {
        // Verify the purchase belongs to the authenticated user
        $purchase = TicketPurchase::where('id', $id)
            ->where('user_id', Auth::user()->id)
            ->first();

        if (!$purchase) {
            return redirect()->route('customer.home')->with('error', 'Purchase not found or unauthorized access.');
        }

        // Get purchase details with joins
        $purchase_data = TicketPurchase::where('ticket_purchase.id', $id)
            ->leftjoin('event', 'event.id', 'ticket_purchase.event_id')
            ->leftjoin('event_tickets', 'event_tickets.id', 'ticket_purchase.event_ticket_id')
            ->leftjoin('event_tags', 'event_tags.id', 'event.event_tag')
            ->leftjoin('event_type', 'event_type.id', 'event.event_type')
            ->leftjoin('currency', 'currency.id', 'ticket_purchase.payment_currency')
            ->leftjoin('purchase_status', 'purchase_status.id', 'ticket_purchase.purchase_status')
            ->select('*', 'ticket_purchase.id as id')
            ->first();

        // Get event date
        $purchase_data->event_date = TicketsGenerated::leftjoin('event_timings', 'event_timings.id', 'event_ticket_tickets.event_timing')
            ->where('purchase_id', $id)
            ->first();

        // Get all tickets with full details for this purchase
        $tickets = TicketsGenerated::where('purchase_id', $id)
            ->leftjoin('event_tickets', 'event_tickets.id', 'event_ticket_tickets.event_tickets')
            ->leftjoin('event_timings', 'event_timings.id', 'event_ticket_tickets.event_timing')
            ->leftjoin('venue_seating', 'venue_seating.id', 'event_ticket_tickets.event_seating')
            ->leftjoin('event', 'event.id', 'event_ticket_tickets.event_id')
            ->select(
                'event_ticket_tickets.id',
                'event_ticket_tickets.file',
                'event_ticket_tickets.ticket_serial_number',
                'event_ticket_tickets.seat_number',
                'event_ticket_tickets.seat_row',
                'event_ticket_tickets.ticket_amount',
                'event_tickets.ticket_name',
                'event_tickets.ticket_type',
                'event_timings.event_date',
                'event_timings.from_time',
                'event_timings.to_time',
                'venue_seating.seating_type_name',
                'event.event_name'
            )
            ->get();

        return view('customer.ticket_details', compact('purchase_data', 'tickets'));
    }

    /**
     * Show the reseller dashboard.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resellerHome()
    {
        return redirect('reseller/event_listing');
    }
}
