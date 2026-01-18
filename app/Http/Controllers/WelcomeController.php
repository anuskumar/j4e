<?php

namespace App\Http\Controllers;

use App\Models\ArtistModel;
use App\Models\Events;
use App\Models\EventTags;
use App\Models\EventTickets;
use App\Models\EventTiming;
use App\Models\RestrictionModel;
use App\Models\SliderModel;
use App\Models\TicketsGenerated;
use App\Models\VenueSeating;
use Illuminate\Http\Request;
use Carbon\Carbon;

class WelcomeController extends Controller
{
    //
    public function index(Request $request){

        $search = $request->get('search');
        $type = $request->get('type');

        // If search is provided, redirect to event list page with search
        if(!empty($search)){
            return redirect()->route('new_eventlistfrontend', ['search' => $search]);
        }

        $slider = SliderModel::get();
        if(empty($type))
        {
             $event_tags = Events::leftjoin('event_tags','event_tags.id','event.event_tag')->groupBy('event.event_tag')
                                ->select('*','event_tags.id as id')->get();
        } else{
             $event_tags = Events::leftjoin('event_tags','event_tags.id','event.event_tag')
                                    ->where('event.event_type',$type)
                                    ->groupBy('event.event_tag')
                                    ->select('*','event_tags.id as id')->get();
        }


        return view('index',compact('event_tags','slider'));


    }





    public function new_eventlistfrontend(Request $request){
        $search = $request->get('search');
        
        if($request->get('tag')){
            $event_tag = EventTags::find($request->get('tag'));
        }else{
            $event_tag = EventTags::first();
        }

        // Build the base query
        $query = Events::
        leftjoin('event_type','event_type.id','event.event_type')
        ->leftjoin('users','users.id','event.event_added_by')
        ->leftjoin('venue','venue.id','event.venue')
        ->leftjoin('location','location.id','venue.location')
        ->leftjoin('countries','countries.id','location.country')
        ->leftjoin('cities','cities.id','location.city');

        // Apply search filter if search parameter exists
        if(!empty($search)){
            // Get artist IDs that match the search
            $artistIds = ArtistModel::where('artist_name', 'LIKE', "%{$search}%")->pluck('id')->toArray();
            
            $query->where(function($q) use ($search, $artistIds) {
                $q->where('event.event_name', 'LIKE', "%{$search}%")
                  ->orWhere('location.location_name', 'LIKE', "%{$search}%")
                  ->orWhere('cities.name', 'LIKE', "%{$search}%")
                  ->orWhere('countries.country_name', 'LIKE', "%{$search}%")
                  ->orWhere('venue.name', 'LIKE', "%{$search}%");
                
                // Search in JSON artists column if artist IDs found
                if(!empty($artistIds)){
                    foreach($artistIds as $artistId){
                        $q->orWhereRaw("JSON_CONTAINS(event.artists, '\"$artistId\"')");
                    }
                }
            });
        } else {
            // If no search, filter by event tag
            $query->where('event.event_tag',$event_tag->id);
        }

        $data = $query->select('*','event.id as id','country_name','cities.name as city_name','location_name','venue.name as venue_name')
       ->get();

        // Get first event for display (or null if no results)
        $data1 = $data->isNotEmpty() ? $data->first() : null;

        foreach ($data as $key) {
            $key['timings'] = EventTiming::where('event',$key->id)->get();

            $key['tickets_available'] = TicketsGenerated::where('event_id',$key->id)
            ->where('is_sold',0)
            ->where('under_purchase_hold',0)
            ->count();
            
            // Get artist names from JSON array
            if(!empty($key->artists)){
                $artistIds = json_decode($key->artists, true);
                if(is_array($artistIds)){
                    $key['artist_names'] = ArtistModel::whereIn('id', $artistIds)->pluck('artist_name')->toArray();
                } else {
                    $key['artist_names'] = [];
                }
            } else {
                $key['artist_names'] = [];
            }
        }

        // Get locations for filter
        $locationQuery = Events::
        leftjoin('event_type','event_type.id','event.event_type')
        ->leftjoin('users','users.id','event.event_added_by')
        ->leftjoin('venue','venue.id','event.venue')
        ->leftjoin('location','location.id','venue.location')
        ->leftjoin('countries','countries.id','location.country')
        ->leftjoin('cities','cities.id','location.city');

        if(!empty($search)){
            // Get artist IDs that match the search for location filter
            $artistIdsForLocation = ArtistModel::where('artist_name', 'LIKE', "%{$search}%")->pluck('id')->toArray();
            
            $locationQuery->where(function($q) use ($search, $artistIdsForLocation) {
                $q->where('event.event_name', 'LIKE', "%{$search}%")
                  ->orWhere('location.location_name', 'LIKE', "%{$search}%")
                  ->orWhere('cities.name', 'LIKE', "%{$search}%")
                  ->orWhere('countries.country_name', 'LIKE', "%{$search}%")
                  ->orWhere('venue.name', 'LIKE', "%{$search}%");
                
                // Search in JSON artists column if artist IDs found
                if(!empty($artistIdsForLocation)){
                    foreach($artistIdsForLocation as $artistId){
                        $q->orWhereRaw("JSON_CONTAINS(event.artists, '\"$artistId\"')");
                    }
                }
            });
        } else {
            $locationQuery->where('event.event_tag',$event_tag->id);
        }

        $location = $locationQuery
        ->groupBy('venue.location')
        ->select('location.id as id','country_name','cities.name as city_name','location_name','venue.name as venue_name')
        ->get();

        return view('new_eventlistfrontend',compact('data','event_tag','location','data1','search'));


    }


    public function event_ticket_listing(Request $request){

        $event = $request->get('event');
        $event_timing = $request->get('event_timing');

        $event_datas = Events::where('event.id',$event)
        ->leftjoin('venue','venue.id','event.venue')
        ->leftjoin('event_tags','event_tags.id','event.event_tag')
         ->leftjoin('location','location.id','venue.location')
        ->leftjoin('countries','countries.id','location.country')
        ->leftjoin('cities','cities.id','location.city')
        ->select('*','event.id as id','venue.image as venue_image','country_name',
        'cities.name as city_name','location_name','venue.name as venue_name','venue.id as venue_id')->first();
        $timing_datas = EventTiming::find($event_timing);
        $seating = VenueSeating::where('venue',$event_datas->venue_id)->get();
        foreach ($seating as $key ) {
            $key['avalable_ticket'] = TicketsGenerated::leftjoin('venue_seating','venue_seating.id','event_ticket_tickets.event_seating')
            ->where('event_ticket_tickets.event_id', $event_datas->id)->
            where('event_ticket_tickets.event_timing', $timing_datas->id)->
            where('venue_seating.id',$key->id)->
            where('event_ticket_tickets.is_sold',0)->
            where('event_ticket_tickets.under_purchase_hold',0)
            ->count();
        }
        // dd($seating);
        $event_datas['seating_categories'] = $seating;


        return view('event_timing_list_frontend',compact('event_datas','timing_datas','event','event_timing'));

    }

    public function ticket_filter_action(Request $request){

        $category = $request->get('category');
        $ticket_number = $request->get('ticket_number');
        $event = $request->get('event_id');
        $event_timing = $request->get('event_timing');


        if(empty($category)||empty($ticket_number)){

            return back();

        }else{
            // dd("here");
            $event_datas = Events::where('event.id',$event)
            ->leftjoin('venue','venue.id','event.venue')
            ->leftjoin('event_tags','event_tags.id','event.event_tag')
             ->leftjoin('location','location.id','venue.location')
            ->leftjoin('countries','countries.id','location.country')
            ->leftjoin('cities','cities.id','location.city')
            ->select('*','event.id as id','venue.image as venue_image','country_name',
            'cities.name as city_name','location_name','venue.name as venue_name','venue.id as venue_id')->first();
            $timing_datas = EventTiming::find($event_timing);
            $seating = VenueSeating::where('venue',$event_datas->venue_id)->get();
            // foreach ($seating as $key ) {
            //     $key['avalable_ticket'] = TicketsGenerated::leftjoin('venue_seating','venue_seating.id','event_ticket_tickets.event_seating')
            //     ->where('event_ticket_tickets.event_id', $event_datas->id)->
            //     where('event_ticket_tickets.event_timing', $timing_datas->id)->
            //     where('venue_seating.id',$key->id)->
            //     where('event_ticket_tickets.is_sold',0)->
            //     where('event_ticket_tickets.under_purchase_hold',0)
            //     ->count();
            // }
            // dd($seating);

            $event_datas['seating_categories'] = $seating;

           $data_all = EventTickets::leftjoin('ticket_type','ticket_type.id','event_tickets.ticket_type')
            ->leftjoin('event','event.id','event_tickets.event')
            ->leftjoin('venue','venue.id','event.venue')
            ->leftjoin('venue_seating','venue_seating.id','event_tickets.venue_seating')
            ->leftjoin('event_timings','event_timings.id','event_tickets.event_timing')
            ->leftjoin('ticket_status','ticket_status.id','event_tickets.ticket_status')
            ->leftjoin('users','users.id','event_tickets.created_by')
            ->leftjoin('currency','currency.id','event_tickets.amount_currency')
            ->where('event_tickets.event',$event)
            ->where('event_tickets.event_timing',$event_timing)
            ->where('event_tickets.is_admin_approved',1);

           $event_ticket_data = $data_all
        //    ->where('event_tickets.venue_seating',$category)
           ->select('*','event_tickets.id as id','event_tickets.is_admin_approved as is_admin_approved'
           ,'users.name as user_name','venue_seating.seating_type_name as seating_type_name')->get();
                // dd($event_ticket_data);
            foreach ($event_ticket_data as $key) {
                $key['ticket_restrictions_data'] =
                RestrictionModel::where('id',json_decode($key->ticket_restrictions))->get();
                $key['availablity'] = TicketsGenerated::where('event_tickets',$key->id)
                ->where('is_sold',0)
                ->where('under_purchase_hold',0)
                ->count();

            }

            // dd($event_ticket_data);
           return view('event_ticket_list_frontend',compact('event_datas','timing_datas','event','event_timing','event_ticket_data'));


        }

     }

}
