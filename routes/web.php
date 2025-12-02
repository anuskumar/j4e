<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\ArtistfiedController;
use App\Http\Controllers\BankTransferController;
use App\Http\Controllers\CompanySettingsController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\Emailj4eController;
use App\Http\Controllers\EventrequestController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\EventTypeController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ResellerController;
use App\Http\Controllers\RestrictionController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\SplitTypeController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\ticketrestrictions;
use App\Http\Controllers\TicketTypeController;
use App\Http\Controllers\VenueController;
use App\Http\Controllers\VenueTypeController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\TagController;
use App\Models\ResellerModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// OUR Routes Starts Here

Route::get('/', [WelcomeController::class, 'index'])->name('welcome.index');
// Route::get('/event_list_frontend', [WelcomeController::class, 'event_list_frontend']);
Route::get('/new_eventlistfrontend', [WelcomeController::class, 'new_eventlistfrontend']);
Route::get('/event_ticket_listing', [WelcomeController::class, 'event_ticket_listing']);
Route::get('/ticket_filter_action', [WelcomeController::class, 'ticket_filter_action']);



// Legacy home route - redirects based on user type
Route::get('/home', [HomeController::class, 'redirectToRoleHome'])->name('home');

// Role-based home routes
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'user.type:superadmin']], function () {
    Route::get('/home', [HomeController::class, 'adminHome'])->name('admin.home');
});

Route::group(['prefix' => 'customer', 'middleware' => ['auth', 'user.type:customer']], function () {
    Route::get('/home', [HomeController::class, 'customerHome'])->name('customer.home');
});

Route::group(['prefix' => 'reseller', 'middleware' => ['auth', 'user.type:reseller']], function () {
    Route::get('/home', [HomeController::class, 'resellerHome'])->name('reseller.home');
});

Route::get('/sell_tickets', [FrontendController::class, 'sell_tickets'])->name('sell_tickets');



// Admin section

Route::get('admin_login', [AdminController::class, 'login']);
Route::post('register_customer', [CustomerController::class, 'store']);
Route::get('reseller_registration', [FrontendController::class, 'reseller_registration']);
Route::post('store_reseller', [FrontendController::class, 're_store']);






Route::group(['prefix' => 'customer'], function () {
    Route::get('create', [CustomerController::class, 'create']);
    Route::get('list', [CustomerController::class, 'index']);
    Route::get('view/{id}', [CustomerController::class, 'show']);
    Route::get('edit/{id}', [CustomerController::class, 'edit']);
    Route::post('update', [CustomerController::class, 'update']);
    Route::get('delete/{id}', [CustomerController::class, 'delete']);
    Route::post('store', [CustomerController::class, 'store']);
    Route::delete('destroy/{id}', [CustomerController::class, 'delete']);
});



Route::group(['prefix' => 'reseller'], function () {
    Route::get('create', [ResellerController::class, 'create']);
    Route::post('store', [ResellerController::class, 'store']);
    Route::get('list', [ResellerController::class, 'index']);
    Route::get('view/{id}', [ResellerController::class, 'show']);
    Route::get('edit/{id}', [ResellerController::class, 'edit']);
    Route::post('update', [ResellerController::class, 'update']);
    Route::delete('delete/{id}', [ResellerController::class, 'delete']);
    Route::post('store', [ResellerController::class, 'store']);
    // Route::delete('destroy/{id}', [ResellerController::class,'delete']);

    Route::get('profile', [ResellerController::class, 'profile'])->name('reseller.profile');
    Route::any('update_profile', [ResellerController::class, 'updateprofile'])->name('reseller.updateprofile');
    Route::post('password/update', [ResellerController::class, 'updatePassword'])->name('reseller.passwordupdate');
    Route::post('bank_data/update', [ResellerController::class, 'updatebankdata'])->name('reseller.bankdataupdate');
    Route::post('address_data/update', [ResellerController::class, 'updateaddressdata'])->name('reseller.addressdataupdate');


    Route::get('login', [FrontendController::class, 'reseller_login']);
    Route::post('login', [FrontendController::class, 'login']);
    Route::get('approval_error', [FrontendController::class, 'approval_error']);
    Route::get('/get-cities', [FrontendController::class, 'getCities'])->name('get.cities');

    Route::get('manage_event', [ResellerController::class, 'manage_event']);
    Route::get('create_event', [ResellerController::class, 'manage_event_create']);
    Route::post('manage_event_store', [ResellerController::class, 'manage_event_store']);

    Route::get('event_view/{id}', [ResellerController::class, 'event_show']);
    Route::get('event_edit/{id}', [ResellerController::class, 'event_edit']);
    Route::post('event_update', [ResellerController::class, 'event_update']);
    Route::delete('destroy/{id}', [ResellerController::class, 'delete_event']);
    Route::get('multi_images/{id}', [ResellerController::class, 'multi_images']);
    Route::post('upload_event_images', [ResellerController::class, 'upload_event_images']);
    Route::get('delete_images/{id}', [ResellerController::class, 'delete_multiimages']);
    Route::get('event_timings/{id}', [ResellerController::class, 'event_timings']);
    Route::post('store_timings', [ResellerController::class, 'store_timings']);
    Route::get('edit_timings/{id}', [ResellerController::class, 'edit_timings']);
    Route::post('update_timings', [ResellerController::class, 'update_timings']);
    Route::delete('delete_timings/{id}', [ResellerController::class, 'delete_timings']);

    Route::get('manage_artist', [ResellerController::class, 'manage_artist']);
    Route::get('artist_create', [ResellerController::class, 'artist_create']);
    Route::post('artist_store', [ResellerController::class, 'artist_store']);
    Route::get('artist_view/{id}', [ResellerController::class, 'artist_show']);
    Route::get('artist_edit/{id}', [ResellerController::class, 'artist_edit']);
    Route::post('artist_update', [ResellerController::class, 'artist_update']);
    Route::delete('delete_artist/{id}', [ResellerController::class, 'delete_artist']);

    Route::get('manage_artistfield', [ResellerController::class, 'manage_artistfield']);
    Route::get('artistfield_create', [ResellerController::class, 'artistfield_create']);
    Route::post('artistfield_store', [ResellerController::class, 'artistfield_store']);

    Route::get('manage_venue', [ResellerController::class, 'manage_venue']);
    Route::get('venue_create', [ResellerController::class, 'venue_create']);
    Route::post('venue_store', [ResellerController::class, 'venue_store']);
    Route::get('venue_view/{id}', [ResellerController::class, 'venue_show']);
    Route::get('venue_edit/{id}', [ResellerController::class, 'venue_edit']);
    Route::post('venue_update', [ResellerController::class, 'venue_update']);
    Route::delete('destroy/{id}', [ResellerController::class, 'delete_venue']);

    Route::get('ticket_events', [ResellerController::class, 'ticket_index']);
    Route::post('ticket_store', [ResellerController::class, 'ticket_store']);
    Route::get('manage_tickets/{id}', [ResellerController::class, 'manage_tickets']);
    Route::get('ticket_create', [ResellerController::class, 'ticket_create']);
    Route::post('store_ticket', [ResellerController::class, 'store_ticket']);


    Route::get('event_listing', [ResellerController::class, 'eventlisting'])->name('reseller.eventlisting');
    Route::get('event_data/{id}', [ResellerController::class, 'eventdata']);
    Route::get('event_list_withtag/{id}', [ResellerController::class, 'event_list_withtag']);
    Route::get('sell_tickets/{id}', [ResellerController::class, 'selltickets'])->name('reseller.selltickets');
    Route::get('sell_currency_code', [ResellerController::class, 'currencycodelist'])->name('reseller.currency');
    Route::get('split_type', [SplitTypeController::class, 'index']);
    Route::any('sell_ticket_save/{id}', [ResellerController::class, 'savesellticket'])->name('reseller.sellticketsave');
    Route::get('cityname', [ResellerController::class, 'countrycode'])->name('reseller.pickcity');



    Route::any('sell_ticket_savesecond/{id}', [ResellerController::class, 'savesellticketsecond'])->name('reseller.savesecond');
    Route::any('sell_ticket_updatesecond/{id}', [ResellerController::class, 'updatesavefunction'])->name('reseller.updateticket');

    //Unnecessary route, no longer using, as per the client requirements

    // Route::get('sell_ticket_address/{id}', [ResellerController::class, 'showaddresform'])->name('reseller.addressform');
    //Unnecessary route, no longer using, as per the client requirements

    // Route::post('save_sellticket_third', [ResellerController::class, 'savesellticketthird'])->name('reseller.savethird');

    Route::any('sell_ticket_conformation/{id}', [ResellerController::class, 'savesellconformation'])->name('reseller.conformation');
    Route::any('bankdetails', [ResellerController::class, 'finalprocess'])->name('reseller.finalprocess');
    Route::post('/bank-details', [BankTransferController::class, 'storeBankDetails'])->name('bank.details.store');
    Route::post('/save-payment-method', [BankTransferController::class, 'savePaymentMethod'])->name('savePaymentMethod');



    Route::get('request-event', [EventrequestController::class, 'requestevent'])->name('reseller.requestevent');
    Route::post('request-eventstore', [EventrequestController::class, 'requesteventstore'])->name('reseller.requesteventstore');

     Route::get('mylistings', [ResellerController::class, 'mylistings'])->name('reseller.mylistings');
     Route::get('mysales', [ResellerController::class, 'mysales'])->name('reseller.mysales');
     Route::get('view-sold-tickets/{id}', [ResellerController::class, 'view_sold_tickets'])->name('reseller.view.soldtickets');

     Route::get('reseller-manage-eventticket/{id}', [ResellerController::class, 'reseller_manage_eventticket'])->name('reseller.manage.eventticket');
     Route::post('update-ticket-type', [ResellerController::class, 'update_ticket_type'])->name('update.ticket.type');
     Route::post('update-ticket-seating', [ResellerController::class, 'update_ticket_seating'])->name('update.ticket.seating');
     Route::post('upload-ticket-seating', [ResellerController::class, 'upload_ticket_seating'])->name('tickets.uploadSplit');
     Route::post('upload-ticket-seating-individual', [ResellerController::class, 'upload_ticket_seating_individual'])->name('tickets.uploadIndividual');

     Route::delete('reseller-delete-listing/{id}', [ResellerController::class, 'destroy_ticket'])->name('ticket.listing.destroy');
     Route::post('update-ticket-pricechange', [ResellerController::class, 'update_ticket_pricechange'])->name('update.ticket.pricechange');

     Route::get('delete-generated-ticket', [ResellerController::class, 'delete_generated_ticket'])->name('delete.generated.ticket');

});

Route::group(['prefix' => 'admin'], function () {
    Route::get('edit/{id}', [CompanySettingsController::class, 'edit']);
    // Route::post('update', [CompanySettingsController::class, 'update']);
    Route::get('company_settings', [CompanySettingsController::class, 'index'])->name('company');
});
// ended Admin Section

Route::group(['prefix' => 'company'], function () {

    Route::post('update', [CompanySettingsController::class, 'update']);
});




Route::group(['prefix' => 'venue'], function () {
    Route::get('create', [VenueController::class, 'create']);
    Route::get('list', [VenueController::class, 'index']);
    Route::post('store', [VenueController::class, 'store']);
    Route::get('view/{id}', [VenueController::class, 'show']);
    Route::get('edit/{id}', [VenueController::class, 'edit']);
    Route::post('update', [VenueController::class, 'update']);
    Route::delete('destroy/{id}', [VenueController::class, 'delete']);
    Route::get('manage_Seating/{id}', [VenueController::class, 'manage_Seating']);
    Route::get('edit_seating/{id}', [VenueController::class, 'edit_seating']);
    Route::post('store_seating', [VenueController::class, 'store_seating']);
    Route::post('update_Seating', [VenueController::class, 'update_Seating']);
    Route::delete('delete_venue_seating/{id}', [VenueController::class, 'delete_seating']);
});
Route::get('/get-city/{countryId}', [VenueController::class, 'getCity'])->name('getCity');


Route::group(['prefix' => 'venuetype'], function () {

    Route::get('create', [VenueTypeController::class, 'create']);
    Route::post('store', [VenueTypeController::class, 'store']);
    Route::get('list', [VenueTypeController::class, 'index']);
    Route::get('view/{id}', [VenueTypeController::class, 'show']);
    Route::get('edit/{id}', [VenueTypeController::class, 'edit']);
    Route::post('update', [VenueTypeController::class, 'update']);
    Route::delete('destroy/{id}', [VenueTypeController::class, 'delete']);
});

Route::group(['prefix' => 'eventtype'], function () {

    Route::get('create', [EventTypeController::class, 'create']);
    Route::post('store', [EventTypeController::class, 'store']);
    Route::get('list', [EventTypeController::class, 'index']);
    Route::get('view/{id}', [EventTypeController::class, 'show']);
    Route::get('edit/{id}', [EventTypeController::class, 'edit']);
    Route::post('update', [EventTypeController::class, 'update']);
    Route::delete('destroy/{id}', [EventTypeController::class, 'delete']);
});

Route::group(['prefix' => 'tickettype'], function () {

    Route::get('create', [TicketTypeController::class, 'create']);
    Route::post('store', [TicketTypeController::class, 'store']);
    Route::get('list', [TicketTypeController::class, 'index']);
    Route::get('view/{id}', [TicketTypeController::class, 'show']);
    Route::get('edit/{id}', [TicketTypeController::class, 'edit']);
    Route::post('update', [TicketTypeController::class, 'update']);
    Route::delete('destroy/{id}', [TicketTypeController::class, 'delete']);
});

Route::group(['prefix' => 'events'], function () {
    Route::get('create', [EventsController::class, 'create']);
    Route::get('list', [EventsController::class, 'index']);
    Route::post('store', [EventsController::class, 'store']);
    Route::get('view/{id}', [EventsController::class, 'show']);
    Route::get('edit/{id}', [EventsController::class, 'edit']);
    Route::post('update', [EventsController::class, 'update']);
    Route::delete('destroy/{id}', [EventsController::class, 'delete']);
    Route::get('multi_images/{id}', [EventsController::class, 'multi_images']);
    Route::post('upload_event_images', [EventsController::class, 'upload_event_images']);
    Route::get('delete_images/{id}', [EventsController::class, 'delete_multiimages']);
    Route::get('event_timings/{id}', [EventsController::class, 'event_timings']);
    Route::post('store_timings', [EventsController::class, 'store_timings']);
    Route::get('edit_timings/{id}', [EventsController::class, 'edit_timings']);
    Route::post('update_timings', [EventsController::class, 'update_timings']);
    Route::delete('delete_timings/{id}', [EventsController::class, 'delete_timings']);
    Route::get('requestlist', [EventsController::class, 'requestlist'])->name('events.requestlist');
});

Route::group(['prefix' => 'tickets'], function () {

    Route::get('/', [TicketController::class, 'index']);
    Route::get('manage_tickets/{id}', [TicketController::class, 'manage_tickets']);
    Route::get('check_availability', [TicketController::class, 'check_availability']);
    Route::get('approve_tickets', [TicketController::class, 'approve_tickets']);
    Route::get('reject_tickets', [TicketController::class, 'reject_tickets']);
    Route::post('store_ticket', [TicketController::class, 'store']);
    Route::get('ticket_view/{id}', [TicketController::class, 'show']);
    Route::delete('delete_main_ticket/{id}', [TicketController::class, 'delete_main_ticket']);
    Route::get('manage_individual_tickets/{id}', [TicketController::class, 'manage_individual_tickets']);
    Route::get('get-individual-ticketdata/{ticketId}', [TicketController::class, 'get_individual_ticketdata']);
    Route::get('ticket_edit/{id}', [TicketController::class, 'ticket_edit']);
    Route::post('update', [TicketController::class, 'update']);
    Route::post('update-hold-status', [TicketController::class, 'updateHoldStatus']);
    Route::post('outsidesell.store', [TicketController::class, 'outsidesell'])->name('tickets.outsidesell.store');
    Route::get('get-outsidesell_data/{outsidesell_id}', [TicketController::class, 'get_outsidesell_data']);
    Route::post('update-ticket-status/{id}', [TicketController::class, 'updateStatus']);
    Route::post('update-ticket-sale-status/{id}', [TicketController::class, 'updatesaleStatus']);
    Route::get('get-ticket-data', [TicketController::class, 'get_ticket_data']);
});

Route::group(['prefix' => 'location'], function () {

    Route::get('list', [LocationController::class, 'index']);
    Route::get('create', [LocationController::class, 'create']);
    Route::post('store', [LocationController::class, 'store']);
    Route::post('get_cities', [LocationController::class, 'get_cities']);
    Route::get('edit/{id}', [LocationController::class, 'edit']);
    Route::post('update', [LocationController::class, 'update']);
    Route::delete('destroy/{id}', [LocationController::class, 'delete']);
});

Route::group(['prefix' => 'city'], function () {

    Route::get('list', [CityController::class, 'index']);
    Route::get('create', [CityController::class, 'create']);
    Route::post('store', [CityController::class, 'store']);
    Route::get('edit/{id}', [CityController::class, 'edit']);
    Route::post('update', [CityController::class, 'update']);
    Route::delete('destroy/{id}', [CityController::class, 'delete']);
});

Route::group(['prefix' => 'artist'], function () {

    Route::get('create', [ArtistController::class, 'create']);
    Route::post('store', [ArtistController::class, 'store']);
    Route::get('list', [ArtistController::class, 'index']);
    Route::get('view/{id}', [ArtistController::class, 'show']);
    Route::get('edit/{id}', [ArtistController::class, 'edit']);
    Route::post('update', [ArtistController::class, 'update']);
    Route::delete('destroy/{id}', [ArtistController::class, 'delete']);
});

Route::group(['prefix' => 'slide'], function () {

    Route::get('create', [SliderController::class, 'create']);
    Route::post('store', [SliderController::class, 'store']);
    Route::get('list', [SliderController::class, 'index']);
    Route::get('view/{id}', [SliderController::class, 'show']);
    Route::get('edit/{id}', [SliderController::class, 'edit']);
    Route::post('update', [SliderController::class, 'update'])->name('slide.update');
    Route::delete('destroy/{id}', [SliderController::class, 'delete']);
});

Route::group(['prefix' => 'customer_order'], function () {

    // Route::get('create', [SliderController::class, 'create']);
    // Route::post('store', [SliderController::class, 'store']);
    Route::get('list', [OrderController::class, 'index']);
    Route::get('old_list', [OrderController::class, 'old_list']);

    Route::get('update_order_status/{id}', [OrderController::class, 'update_order_status']);
    // Route::get('edit/{id}', [SliderController::class, 'edit']);
    Route::post('order_status_change', [OrderController::class, 'order_status_change'])->name('order_status_change');
    Route::get('delete_status_log/{id}', [OrderController::class, 'delete_status_log']);
    // Route::delete('destroy/{id}', [SliderController::class,'delete']);



});





Route::group(['prefix' => 'artistfield'], function () {

    Route::get('create', [ArtistfiedController::class, 'create']);
    Route::post('store', [ArtistfiedController::class, 'store']);
    Route::get('list', [ArtistfiedController::class, 'index']);
    Route::get('view/{id}', [ArtistfiedController::class, 'show']);
    Route::get('edit/{id}', [ArtistfiedController::class, 'edit']);
    Route::post('update', [ArtistfiedController::class, 'update']);
    Route::delete('destroy/{id}', [ArtistfiedController::class, 'delete']);
});



Route::group(['prefix' => 'currency', 'middleware' => 'auth'], function () {

    Route::get('create', [CurrencyController::class, 'create']);
    Route::post('store', [CurrencyController::class, 'store']);
    Route::get('list', [CurrencyController::class, 'index']);
    Route::get('view/{id}', [CurrencyController::class, 'show']);
    Route::get('edit/{id}', [CurrencyController::class, 'edit']);
    Route::post('update', [CurrencyController::class, 'update']);
    Route::delete('destroy/{id}', [CurrencyController::class, 'delete']);
});
Route::get('/get-currency-rate/{id}', [CurrencyController::class, 'getRate']);

Route::group(['prefix' => 'ticket_restrictions'], function () {

    Route::get('create', [RestrictionController::class, 'create']);
    Route::post('store', [RestrictionController::class, 'store']);
    Route::get('list', [RestrictionController::class, 'index']);
    Route::delete('destroy/{id}', [RestrictionController::class, 'delete']);
});

Route::group(['prefix' => 'eventtags'], function () {

    Route::get('/', [TagController::class, 'index']);
    Route::get('list', [TagController::class, 'index'])->name('eventtags.list');
    Route::get('create', [TagController::class, 'create']);
    Route::post('store', [TagController::class, 'store']);
    Route::get('view/{id}', [TagController::class, 'show']);
    Route::get('edit/{id}', [TagController::class, 'edit']);
    Route::post('update', [TagController::class, 'update']);
    Route::delete('destroy/{id}', [TagController::class, 'delete']);
});


// Our ROutes Ends Here


Route::controller(StripePaymentController::class)->group(function () {
    Route::get('stripe', 'stripe');
    Route::post('stripe', 'stripePost')->name('stripe.post');
});


Route::controller(FrontendController::class)->group(function () {
    Route::post('submit_ticket_selected', 'submit_ticket_selected')->middleware('auth');
    Route::get('customer_ticket_billing_page/{id}', 'customer_ticket_billing_page')->middleware('auth')->name('customer_ticket_billing_page');
    Route::get('ticket_purchase_expired', 'ticket_purchase_expired')->middleware('auth');
    Route::get('release_my_tickets', 'release_my_tickets')->middleware('auth');
    Route::get('booking_success/{id}', 'booking_success')->middleware('auth');
    Route::get('booking_failed', 'booking_failed');
    Route::get('view_invoice/{id}', 'view_invoice')->middleware('auth');
    Route::get('show_details_show/{id}', 'show_details_show');
    Route::get('show_booking_details_show/{id}', 'show_booking_details_show')->middleware('auth');
    Route::post('update-facevalue-ticket', 'updatefacevalueticket')->middleware('auth');


    Route::get('customer_profile_settings', 'customer_profile_settings')->middleware('auth');
    Route::post('/upload-ticket/{id}', 'upload_ticket')->name('upload.ticket');

    Route::post('/filter-tickets', 'filterTickets');
    Route::get('/get-seating-types/{eventId}', 'getSeatingTypes');
    Route::post('/customer-update-profile', 'update_customer_profile')->middleware('auth')->name('customer.profile.update');
});

// Route::controller(EmailController::class)->group(function(){

//     Route::any('email','requestemail')->name('email.requestemail');
// });
Route::controller(Emailj4eController::class)->group(function () {

    Route::any('test-email', 'sendEmail')->name('email.requestemail');
    Route::any('ticketsold-email', 'ticketsoldmail')->name('email.ticketsold');
    Route::any('ticketupload-email', 'ticketuploadmail')->name('email.ticketupload');
    Route::any('ticketdelivered-email', 'ticketdeliveredmail')->name('email.ticketdelivered');
    Route::any('ticketexpired-email', 'ticketexpiredmail')->name('email.ticketexpired');
    Route::any('ticketpaid-email', 'ticketpaidmail')->name('email.ticketpaid');
    // Route::any('ticketappoved-email','ticketapprovedmail')->name('email.ticketapproved');
    Route::any('ticketapproved-email', 'ticketapprovedmail')->name('email.ticketapproved');
});


Route::view('/booking_success_modal', 'booking_success_modal')->name('booking_success_modal');
Route::view('/booking_failed_modal', 'booking_failed_modal')->name('booking_failed_modal');







// Route::get('/index', function () {
//     return view('index');
// })->name('page');
// Route::get('/add-billing', function () {
//     return view('add-billing');
// })->name('add-billing');
// Route::get('/blank-page', function () {
//     return view('blank-page');
// })->name('blank-page');
// Route::get('/blog-details', function () {
//     return view('blog-details');
// })->name('blog-details');
// Route::get('/blog-grid', function () {
//     return view('blog-grid');
// })->name('blog-grid');
// Route::get('/blog-list', function () {
//     return view('blog-list');
// })->name('blog-list');
// Route::get('/booking-success', function () {
//     return view('booking-success');
// })->name('booking-success');
// Route::get('/booking', function () {
//     return view('booking');
// })->name('booking');
// Route::get('/calendar', function () {
//     return view('calendar');
// })->name('calendar');
// Route::get('/change-password', function () {
//     return view('change-password');
// })->name('change-password');
// Route::get('/chat', function () {
//     return view('chat');
// })->name('chat');
// Route::get('/checkout', function () {
//     return view('checkout');
// })->name('checkout');
// Route::get('/components', function () {
//     return view('components');
// })->name('components');
// Route::get('/favourites', function () {
//     return view('favourites');
// })->name('favourites');
// Route::get('/forgot-password', function () {
//     return view('forgot-password');
// })->name('forgot-password');
// Route::get('/invoice-view', function () {
//     return view('invoice-view');
// })->name('invoice-view');
// Route::get('/invoices', function () {
//     return view('invoices');
// })->name('invoices');
// Route::get('/login-old', function () {
//     return view('login');
// })->name('login');
// Route::get('/map-grid', function () {
//     return view('map-grid');
// })->name('map-grid');
// Route::get('/voice-call', function () {
//     return view('voice-call');
// })->name('voice-call');
// Route::get('/video-call', function () {
//     return view('video-call');
// })->name('video-call');
// Route::get('/term-condition', function () {
//     return view('term-condition');
// })->name('term-condition');
// Route::get('/social-media', function () {
//     return view('social-media');
// })->name('social-media');
// Route::get('/search', function () {
//     return view('search');
// })->name('search');
// Route::get('/schedule-timings', function () {
//     return view('schedule-timings');
// })->name('schedule-timings');
// Route::get('/reviews', function () {
//     return view('reviews');
// })->name('reviews');
// Route::get('/register-old', function () {
//     return view('register');
// })->name('register');
// Route::get('/profile-settings', function () {
//     return view('profile-settings');
// })->name('profile-settings');
// Route::get('/privacy-policy', function () {
//     return view('privacy-policy');
// })->name('privacy-policy');
// Route::get('/map-list', function () {
//     return view('map-list');
// })->name('map-list');
// Route::get('/add-programs', function () {
//     return view('add-programs');
// })->name('add-programs');
// Route::get('/chat-speaker', function () {
//     return view('chat-speaker');
// })->name('chat-speaker');
// Route::get('/customer-dashboard', function () {
//     return view('customer-dashboard');
// })->name('customer-dashboard');
// Route::get('/customer-profile', function () {
//     return view('customer-profile');
// })->name('customer-profile');
// Route::get('/edit-billing', function () {
//     return view('edit-billing');
// })->name('edit-billing');
// Route::get('/edit-programs', function () {
//     return view('edit-programs');
// })->name('edit-programs');
// Route::get('/event-details', function () {
//     return view('event-details');
// })->name('event-details');
// Route::get('/events', function () {
//     return view('events');
// })->name('events');
// Route::get('/my-customers', function () {
//     return view('my-customers');
// })->name('my-customers');
// Route::get('/speaker-change-password', function () {
//     return view('speaker-change-password');
// })->name('speaker-change-password');
// Route::get('/speaker-dashboard', function () {
//     return view('speaker-dashboard');
// })->name('speaker-dashboard');
// Route::get('/speaker-profile-settings', function () {
//     return view('speaker-profile-settings');
// })->name('speaker-profile-settings');
// Route::get('/speaker-profile', function () {
//     return view('speaker-profile');
// })->name('speaker-profile');
// Route::get('/speaker-register', function () {
//     return view('speaker-register');
// })->name('speaker-register');

Auth::routes();
