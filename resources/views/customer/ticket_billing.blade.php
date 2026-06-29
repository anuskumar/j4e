<?php $page = 'customer-profile'; ?>

@extends('layout.mainlayout')
@section('content')
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css"> --}}

    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" /> --}}

    <!-- Breadcrumb -->

    <!-- /Breadcrumb -->

    <!-- Page Content -->
    <style>
        .session-timer-card {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            background: #fff;
            padding: 18px;
            margin-bottom: 20px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
        }

        .session-timer-card__row {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 16px;
        }

        .session-timer-ring {
            position: relative;
            width: 88px;
            height: 88px;
            flex-shrink: 0;
        }

        .session-timer-ring svg {
            width: 100%;
            height: 100%;
            transform: rotate(-90deg);
        }

        .session-timer-ring__bg {
            fill: none;
            stroke: #eef2f2;
            stroke-width: 6;
        }

        .session-timer-ring__progress {
            fill: none;
            stroke: #5cb8b2;
            stroke-width: 6;
            stroke-linecap: round;
            stroke-dasharray: 251.2;
            stroke-dashoffset: 0;
            transition: stroke-dashoffset 0.35s linear;
        }

        .session-timer-ring__time {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: 700;
            color: #111827;
            line-height: 1;
        }

        .session-timer-card__info h4 {
            font-size: 16px;
            font-weight: 700;
            color: #111827;
            margin: 0 0 6px;
        }

        .session-timer-card__info p {
            font-size: 13px;
            color: #6b7280;
            margin: 0 0 4px;
            line-height: 1.45;
        }

        .session-timer-card__info .session-timer-card__reserved {
            color: #5cb8b2;
            font-weight: 600;
            margin-top: 4px;
        }

        .session-timer-card__expired {
            text-align: center;
            padding: 8px 0 12px;
        }

        .session-timer-card__expired h4 {
            font-size: 18px;
            font-weight: 700;
            color: #dc2626;
            margin-bottom: 8px;
        }

        .btn-release-tickets {
            display: block;
            width: 100%;
            background: #5cb8b2;
            border: none;
            color: #fff;
            font-weight: 700;
            font-size: 14px;
            padding: 12px 16px;
            border-radius: 8px;
            text-align: center;
            text-decoration: none;
            transition: background 0.2s ease;
        }

        .btn-release-tickets:hover {
            background: #49a59f;
            color: #fff;
        }

        .personal-details-card {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
        }

        .personal-details-card .card-title {
            font-size: 18px;
            font-weight: 700;
            color: #111827;
            margin: 0;
        }

        .personal-details-edit {
            color: #5cb8b2;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
        }

        .personal-details-edit:hover {
            color: #49a59f;
            text-decoration: underline;
        }

        .personal-details-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .personal-details-list li {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            color: #374151;
            padding: 6px 0;
        }

        .personal-details-list li i {
            width: 16px;
            color: #7e0982;
        }

        .booking-restrictions-wrap {
            margin-top: 12px;
        }

        .booking-restrictions-wrap .label {
            display: block;
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 8px;
        }

        .restriction-tag {
            display: inline-block;
            background: #fffbeb;
            border: 1px solid #fde68a;
            color: #92400e;
            font-size: 12px;
            font-weight: 600;
            border-radius: 6px;
            padding: 4px 8px;
            margin: 0 6px 6px 0;
        }

        .ticket-pricing-summary {
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 16px 18px;
            margin-bottom: 24px;
            background: #f9fafb;
        }

        .ticket-pricing-summary .card-title {
            font-size: 18px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 14px;
        }

        .ticket-pricing-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .ticket-pricing-list li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            color: #374151;
            padding: 8px 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .ticket-pricing-list li:last-child {
            border-bottom: none;
        }

        .ticket-pricing-list li span:last-child {
            font-weight: 600;
            color: #111827;
            text-align: right;
        }

        .ticket-pricing-list .ticket-pricing-total {
            margin-top: 6px;
            padding-top: 12px;
            border-top: 2px solid #e5e7eb;
            font-size: 16px;
            font-weight: 700;
        }

        .ticket-pricing-list .ticket-pricing-total span:last-child {
            color: #7e0982;
            font-size: 18px;
        }
    </style>

    <div class="content">
        <div class="container">

            <div class="row">
                <div class="col-md-4 col-lg-4 col-xl-3 theiaStickySidebar">

                    <!-- Profile Widget -->

                    <div class="session-timer-card">
                        @if ($remainingSeconds > 0)
                            <div class="session-timer-card__row">
                                <div class="session-timer-ring" aria-hidden="true">
                                    <svg viewBox="0 0 100 100">
                                        <circle class="session-timer-ring__bg" cx="50" cy="50" r="40"></circle>
                                        <circle class="session-timer-ring__progress" id="timer-progress" cx="50" cy="50" r="40"></circle>
                                    </svg>
                                    <div class="session-timer-ring__time" id="time">--:--</div>
                                </div>
                                <div class="session-timer-card__info">
                                    <h4>Time Remaining</h4>
                                    <p>For security reasons, your session will expire automatically</p>
                                    <p class="session-timer-card__reserved">Tickets are reserved</p>
                                </div>
                            </div>
                        @else
                            <div class="session-timer-card__expired">
                                <h4>Session Expired</h4>
                                <p class="text-muted mb-0">Your ticket hold has ended. Please return to the event page to try again.</p>
                            </div>
                        @endif
                        <a href="{{ route('customer_ticket_cart') }}" class="btn-release-tickets">View Cart & Release Tickets</a>
                    </div>
                    <div class="card booking-card">
                        <div class="card-header">
                            <h4 class="card-title">Booking Summary</h4>
                        </div>
                        <div class="card-body">

                            <!-- Booking speaker Info -->
                            <div class="booking-doc-info">
                                <a href="speaker-profile" class="booking-doc-img">
                                    @if($data->event_image)
                                        <img src="{{ asset('storage/uploads/events/' . $data->event_image) }}" alt="User Image" onerror="this.src='{{ asset('assets/img/default-event.jpg') }}'">
                                    @else
                                        <img src="{{ asset('assets/img/default-event.jpg') }}" alt="User Image">
                                    @endif
                                </a>
                                <div class="booking-info">
                                    <h4><a href="{{ url('show_details_show',$data->event) }}" target="_blank">
                                        {{ Str::ucfirst($data->event_name) }}</a></h4>
                                    {{-- <div class="rating">
                                        <i class="fas fa-star filled"></i>
                                        <i class="fas fa-star filled"></i>
                                        <i class="fas fa-star filled"></i>
                                        <i class="fas fa-star filled"></i>
                                        <i class="fas fa-star"></i>
                                        <span class="d-inline-block average-rating">35</span>
                                    </div> --}}
                                    <div class="clinic-details">
                                        <p class="doc-location"><i class="fas fa-map-marker-alt"></i>
                                            {{ Str::ucfirst($data->venue_name) }},{{ Str::ucfirst($data->location_name) }}
                                        ,{{ Str::ucfirst($data->country_name) }}</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Booking speaker Info -->
<hr>
                            <div class="booking-summary">
                                <div class="booking-item-wrap">
                                    @php
                                        $max_calculator_tickets = max(1, (int) ($available_ticket_count ?? $ticket_count ?? 1));
                                        $initial_ticket_count = (int) ($ticket_count ?? 1);
                                        if ($initial_ticket_count < 1) {
                                            $initial_ticket_count = 1;
                                        }
                                        if ($initial_ticket_count > $max_calculator_tickets) {
                                            $initial_ticket_count = $max_calculator_tickets;
                                        }
                                        // Billing uses ticket_amount (customer selling price), fallback to web_price
                                        $ticket_price = (float) ($data->ticket_amount ?? $data->web_price ?? 0);
                                        $total_amount = $ticket_price * $initial_ticket_count;
                                    @endphp
                                    <ul class="booking-date">
                                        <li>Date <span>{{ date('d M Y',strtotime($data->event_date)) }}</span></li>
                                        <li>Time <span>{{ date('H:i A',strtotime($data->event_time)) }}</span></li>
                                    </ul>
                                    <ul class="booking-fee">
                                        <li>Ticket Name <span>{{ Str::ucfirst($data->ticket_name) }}</span></li>
                                        @if (!empty($data->seating_type_name))
                                            <li>Zone <span>{{ $data->seating_type_name }}</span></li>
                                        @endif
                                        @if (!empty($data->row))
                                            <li>Row <span>{{ $data->row }}</span></li>
                                        @endif
                                        @if (!empty($data->seat_from) && !empty($data->seat_to))
                                            <li>Seats <span>{{ $data->seat_from }} – {{ $data->seat_to }}</span></li>
                                        @endif
                                        @if (!empty($data->ticket_type_name))
                                            <li>Ticket Type <span>{{ $data->ticket_type_name }}</span></li>
                                        @endif
                                        @if (!empty($data->split_type_name))
                                            <li>Split Type <span>{{ $data->split_type_name }}</span></li>
                                        @endif
                                        <li>Number of Tickets <span id="selected-qty-display">{{ $initial_ticket_count }}</span></li>
                                    </ul>
                                    @if (!empty($restrictionLabels))
                                        <div class="booking-restrictions-wrap">
                                            <span class="label">Restrictions</span>
                                            @foreach ($restrictionLabels as $restriction)
                                                <span class="restriction-tag">{{ $restriction }}</span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-8 col-lg-8 col-xl-9">
                    <div class="card personal-details-card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h4 class="card-title">Personal Details</h4>
                                <a href="{{ url('customer_profile_settings') }}" class="personal-details-edit">Edit</a>
                            </div>
                            <ul class="personal-details-list">
                                <li><i class="fas fa-user"></i> {{ Auth::user()->name }}</li>
                                <li><i class="fas fa-envelope"></i> {{ Auth::user()->email }}</li>
                                <li><i class="fas fa-phone"></i> {{ Auth::user()->phone ?? 'Not provided' }}</li>
                            </ul>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            @if (Session::has('success'))
                            <div class="alert alert-success text-center">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                                <p>{{ Session::get('success') }}</p>
                            </div>
                        @endif

                            <!-- Checkout Form -->
                            <form role="form"
                            action="{{ route('stripe.post') }}"
                            method="post"
                            class="require-validation"
                            data-cc-on-file="true"
                            data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"
                            id="payment-form">

                                <!-- Personal Information -->
                                <!-- <div class="info-widget">
                                    <h4 class="card-title">Personal Information</h4>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group card-label">
                                                <label>Name</label>
                                                <input class="form-control" name="name" value="{{ Auth::user()->name }}" type="text">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group card-label">
                                                <label>Address</label>
                                                <textarea class="form-control" name="customer_address">{{ Auth::user()->address }} </textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group card-label">
                                                <label>Email</label>
                                                <input class="form-control" type="email" name="email"
                                                 value="{{ Auth::user()->email }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group card-label">
                                                <label>Phone</label>
                                                <input class="form-control"  value="{{ Auth::user()->phone }}" type="text" name="phone" >
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group card-label">
                                                <label>Country</label>
                                               <select class="form-control" name="shipping_country" required>

                                                <option value=""> select</option>
                                                @foreach ($countries as $country )

                                                <option value="{{ $country->id }}">{{ $country->country_code }}-{{ $country->country_name }}</option>

                                                @endforeach

                                               </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group card-label">
                                                <label>City</label>
                                                <select name="city" id="city" class="form-control select2-select">
                                                    <option>Select</option>
                                                    <option value="">Select</option>


                                                </select>
                                            </div>
                                        </div>

                                    </div>

                                </div> -->

                                @php
                                    // Keep submitted payable amount aligned with displayed ticket amount
                                    $ticket_price_form = (float) ($data->ticket_amount ?? $data->web_price ?? 0);
                                    $total_amount_form = $ticket_price_form * $initial_ticket_count;
                                    // Round to 2 decimal places to preserve cents
                                    $total_amount_form = round($total_amount_form, 2);
                                @endphp
                                <input type="hidden" value="{{ $total_amount_form }}" name="payment_amount" id="payment-amount-input">
                                <input type="hidden" value="{{ $data->event_id }}" name="event_id">
                                <input type="hidden" value="{{ $data->id }}" name="event_ticket_id">
                                <input type="hidden" value="{{ $initial_ticket_count }}" name="total_number" id="total-number-input">
                                <input type="hidden" value="{{ $data->currency_name }}" name="currency_name">

                                {{-- <input type="hidden" value="{{ round($data->web_price * $ticket_count) }}" name="payment_amount"> --}}



                                <div class="info-widget" id="shipping-information">
                                   <h4 class="card-title">Shipping Information</h4>
                                   @if ($errors->any())
                                       <div class="alert alert-danger">
                                           <ul class="mb-0">
                                               @foreach ($errors->all() as $error)
                                                   <li>{{ $error }}</li>
                                               @endforeach
                                           </ul>
                                       </div>
                                   @endif
                                   <div class="row">
                                       <div class="col-md-6 col-sm-12">
                                           <div class="form-group card-label">
                                               <label>Name <span class="text-danger">*</span></label>
                                               <input class="form-control @error('shipping_name') is-invalid @enderror" name="shipping_name" value="{{ old('shipping_name', Auth::user()->shipping_name ?: Auth::user()->name) }}" type="text" required>
                                               @error('shipping_name')
                                                   <div class="invalid-feedback">{{ $message }}</div>
                                               @enderror
                                           </div>
                                       </div>
                                       <div class="col-md-6 col-sm-12">
                                           <div class="form-group card-label">
                                               <label>Address Line 1 <span class="text-danger">*</span></label>
                                               <textarea class="form-control @error('shipping_address1') is-invalid @enderror" name="shipping_address1" required>{{ old('shipping_address1', Auth::user()->address) }}</textarea>
                                               @error('shipping_address1')
                                                   <div class="invalid-feedback">{{ $message }}</div>
                                               @enderror
                                           </div>
                                       </div>
                                       <div class="col-md-6 col-sm-12">
                                           <div class="form-group card-label">
                                               <label>Address Line 2</label>
                                               <textarea class="form-control @error('shipping_address2') is-invalid @enderror" name="shipping_address2">{{ old('shipping_address2', Auth::user()->shipping_address2) }}</textarea>
                                               @error('shipping_address2')
                                                   <div class="invalid-feedback">{{ $message }}</div>
                                               @enderror
                                           </div>
                                       </div>
                                       <div class="col-md-6 col-sm-12">
                                           <div class="form-group card-label">
                                               <label>Country <span class="text-danger">*</span></label>
                                              <select class="form-control @error('shipping_country') is-invalid @enderror" name="shipping_country" id="shipping_country" required>
                                               <option value="">Select Country</option>
                                               @foreach ($countries as $country )
                                               <option value="{{ $country->id }}" {{ (string) old('shipping_country', Auth::user()->shipping_country) === (string) $country->id ? 'selected' : '' }}>{{ $country->country_name }}</option>
                                               @endforeach
                                              </select>
                                               @error('shipping_country')
                                                   <div class="invalid-feedback">{{ $message }}</div>
                                               @enderror
                                           </div>
                                       </div>
                                       <div class="col-md-6 col-sm-12">
                                           <div class="form-group card-label">
                                               <label>City <span class="text-danger">*</span></label>
                                               <input class="form-control @error('shipping_city') is-invalid @enderror" type="text" name="shipping_city" value="{{ old('shipping_city', Auth::user()->shipping_city) }}" required>
                                               @error('shipping_city')
                                                   <div class="invalid-feedback">{{ $message }}</div>
                                               @enderror
                                           </div>
                                       </div>
                                       <div class="col-md-6 col-sm-12">
                                           <div class="form-group card-label">
                                               <label>Pincode <span class="text-danger">*</span></label>
                                               <input class="form-control @error('shipping_pincode') is-invalid @enderror" type="text" name="shipping_pincode" value="{{ old('shipping_pincode', Auth::user()->shipping_pincode) }}" required>
                                               @error('shipping_pincode')
                                                   <div class="invalid-feedback">{{ $message }}</div>
                                               @enderror
                                           </div>
                                       </div>
                                   </div>

                                </div>



                                <!-- /Personal Information -->

                                <div class="info-widget ticket-pricing-summary">
                                    <h4 class="card-title">Ticket Pricing</h4>
                                    <ul class="ticket-pricing-list">
                                        <li>
                                            <span>Single Ticket Amount</span>
                                            <span id="ticket-amount-display">{{ number_format($ticket_price_form, 2) . ' ' . $data->short_name }} each</span>
                                        </li>
                                        <li>
                                            <span>Number of Tickets</span>
                                            <span>{{ $initial_ticket_count }}</span>
                                        </li>
                                        <li>
                                            <span>Subtotal</span>
                                            <span id="total-amount-display">{{ $initial_ticket_count }} x {{ number_format($ticket_price_form, 2) . ' ' . $data->short_name }} = {{ number_format($total_amount_form, 2) . ' ' . $data->short_name }}</span>
                                        </li>
                                        <li class="ticket-pricing-total">
                                            <span>Final Amount</span>
                                            <span id="final-amount-display">{{ number_format($total_amount_form, 2) . ' ' . $data->short_name }}</span>
                                        </li>
                                    </ul>
                                </div>

                                <div class="payment-widget">
                                    <h4 class="card-title">Payment Method</h4>

                                    <!-- Credit Card Payment -->
                                    <div class="payment-list">
                                        <label class="payment-radio credit-card-option">
                                            <input type="radio" name="radio" checked>
                                            <span class="checkmark"></span>
                                            Credit/Debit Card
                                        </label>
                                        <div class="row">
                                            @if (Session::has('success'))
                                            <div class="alert alert-success text-center">
                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                                                <p>{{ Session::get('success') }}</p>
                                            </div>
                                        @endif


                                    @csrf

                                    <script src="https://checkout.stripe.com/checkout.js"></script>
                                    <button type="button" id="open-stripe-checkout" class="btn btn-primary">
                                        Pay {{ number_format($total_amount_form, 2) }} {{ $data->currency_name }} ({{ $initial_ticket_count }} ticket(s))
                                    </button>
                                            {{-- <div class="col-md-6">
                                                <div class="form-group card-label">
                                                    <label for="card_name">Name on Card</label>
                                                    <input autocomplete='off' class='form-control card-name' size='20' required>

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group card-label">
                                                    <label for="card_number">Card Number</label>
                                                    <input autocomplete='off' name="card_no" class='form-control card-number' size='20'
                                                    type='text' required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group card-label">
                                                    <label for="expiry_month">Expiry Month</label>
                                                    <input
                                    class='form-control card-expiry-month' placeholder='MM' size='2'
                                    type='text' required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group card-label">
                                                    <label for="expiry_year">Expiry Year</label>
                                                    <input
                                                    class='form-control card-expiry-year' placeholder='YYYY' size='4'
                                                    type='text' required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group card-label">
                                                    <label for="cvv">CVV</label>
                                                    <input autocomplete='off'
                                                    class='form-control card-cvc' placeholder='ex. 311' size='4'
                                                    type='text' required>
                                                </div>
                                            </div>


                                        </div>

                                    </div> --}}
                                    <!-- /Credit Card Payment -->

                                    <!-- Paypal Payment -->
                                    {{-- <div class="payment-list">
                                        <label class="payment-radio paypal-option">
                                            <input type="radio" name="radio">
                                            <span class="checkmark"></span>
                                            Paypal
                                        </label>
                                    </div> --}}
                                    <!-- /Paypal Payment -->

                                    <!-- Terms Accept -->
                                    {{-- <div class="terms-accept">
                                        <div class="custom-checkbox">
                                            <input type="checkbox" id="terms_accept" name="accepted_tearms_condetion" required>
                                            <label for="terms_accept">I have read and accept <a href="#">Terms &amp;
                                                    Conditions</a></label>
                                        </div>
                                    </div> --}}
                                    <!-- /Terms Accept -->
                                    {{-- <div class='form-row row'>
                                        <div class='col-md-12 error form-group hide'>
                                            <div class='alert-danger alert'>Please correct the errors and try
                                                again.</div>
                                        </div>
                                    </div> --}}

                                    <!-- Submit Section -->
                                    {{-- <div class="submit-section mt-4">
                                        <button type="submit" class="btn btn-primary submit-btn">Confirm and Pay</button>
                                    </div> --}}
                                    <!-- /Submit Section -->

                                </div>
                            </form>
                            <!-- /Checkout Form -->

                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <!-- /Page Content -->
    </div>

    

    <script>
        (function () {
            var remainingSeconds = {{ (int) $remainingSeconds }};
            var totalSeconds = {{ (int) $sessionDurationSeconds }};
            var circumference = 2 * Math.PI * 40;
            var display = document.getElementById('time');
            var progressRing = document.getElementById('timer-progress');

            if (!display || !progressRing || remainingSeconds <= 0) {
                return;
            }

            progressRing.style.strokeDasharray = circumference;
            progressRing.style.strokeDashoffset = circumference * (1 - (remainingSeconds / totalSeconds));

            function formatTime(seconds) {
                var minutes = Math.floor(seconds / 60);
                var secs = seconds % 60;
                return minutes + ':' + (secs < 10 ? '0' + secs : secs);
            }

            display.textContent = formatTime(remainingSeconds);

            var interval = setInterval(function () {
                remainingSeconds -= 1;

                if (remainingSeconds <= 0) {
                    display.textContent = '0:00';
                    progressRing.style.strokeDashoffset = circumference;
                    clearInterval(interval);
                    window.location.href = "{{ url('ticket_purchase_expired') }}";
                    return;
                }

                display.textContent = formatTime(remainingSeconds);
                progressRing.style.strokeDashoffset = circumference * (1 - (remainingSeconds / totalSeconds));
            }, 1000);
        })();
    </script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css">

  {{-- <script>
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-left",
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "37777777700",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }

        @if (Session::has('success'))

        // console.log('got success');
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.success("{{ session('success') }}");
        @endif

        @if (Session::has('error'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.error("{{ session('error') }}");
        @endif

        @if (Session::has('danger'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.error("{{ session('danger') }}");
        @endif

        @if (Session::has('info'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.info("{{ session('info') }}");
        @endif

        @if (Session::has('warning'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.warning("{{ session('warning') }}");
        @endif
    </script> --}}
    <script type="text/javascript">



    $(function() {


        /*------------------------------------------
        --------------------------------------------
        Stripe Payment Code
        --------------------------------------------
        --------------------------------------------*/

        var $form = $(".require-validation");
        $('form.require-validation').bind('submit', function(e) {
            var $form = $(".require-validation"),
            inputSelector = ['input[type=email]', 'input[type=password]',
                             'input[type=text]', 'input[type=file]',
                             'textarea'].join(', '),
            $inputs = $form.find('.required').find(inputSelector),
            $errorMessage = $form.find('div.error'),
            valid = true;
            $errorMessage.addClass('hide');

            $('.has-error').removeClass('has-error');
            $inputs.each(function(i, el) {
              var $input = $(el);
              if ($input.val() === '') {
                $input.parent().addClass('has-error');
                $errorMessage.removeClass('hide');
                e.preventDefault();
              }
            });

            if (!$form.data('cc-on-file')) {
              e.preventDefault();
              Stripe.setPublishableKey($form.data('stripe-publishable-key'));
              Stripe.createToken({
                number: $('.card-number').val(),
                cvc: $('.card-cvc').val(),
                exp_month: $('.card-expiry-month').val(),
                exp_year: $('.card-expiry-year').val()
              }, stripeResponseHandler);
            }

        });

        /*------------------------------------------
        --------------------------------------------
        Stripe Response Handler
        --------------------------------------------
        --------------------------------------------*/
        function stripeResponseHandler(status, response) {
            if (response.error) {
                $('.error')
                    .removeClass('hide')
                    .find('.alert')
                    .text(response.error.message);
            } else {
                /* token contains id, last4, and card type */
                var token = response['id'];

                $form.find('input[type=text]').empty();
                $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                $form.get(0).submit();
            }
        }

    });


    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var unitPrice = parseFloat("{{ (float) ($data->ticket_amount ?? $data->web_price ?? 0) }}");
        var ticketQty = parseInt("{{ (int) $initial_ticket_count }}", 10);
        var currencyCode = "{{ $data->short_name }}";

        var stripeHandler = StripeCheckout.configure({
            key: "{{ config('services.stripe.key') }}",
            locale: 'auto',
            token: function(token) {
                if ($('#stripe-token-input').length === 0) {
                    $('#payment-form').append('<input type="hidden" id="stripe-token-input" name="stripeToken" />');
                }
                $('#stripe-token-input').val(token.id);
                $('#payment-form')[0].submit();
            }
        });

        function validateShippingForm() {
            var isValid = true;
            var errorMessages = [];
            
            // Validate shipping name
            if ($('input[name="shipping_name"]').val().trim() === '') {
                $('input[name="shipping_name"]').addClass('is-invalid');
                isValid = false;
                errorMessages.push('Please enter your name.');
            } else {
                $('input[name="shipping_name"]').removeClass('is-invalid');
            }
            
            // Validate shipping address
            if ($('textarea[name="shipping_address1"]').val().trim() === '') {
                $('textarea[name="shipping_address1"]').addClass('is-invalid');
                isValid = false;
                errorMessages.push('Please enter your address.');
            } else {
                $('textarea[name="shipping_address1"]').removeClass('is-invalid');
            }
            
            // Validate country
            if ($('select[name="shipping_country"]').val() === '' || $('select[name="shipping_country"]').val() === null) {
                $('select[name="shipping_country"]').addClass('is-invalid');
                isValid = false;
                errorMessages.push('Please select a country.');
            } else {
                $('select[name="shipping_country"]').removeClass('is-invalid');
            }
            
            // Validate city
            if ($('input[name="shipping_city"]').val().trim() === '') {
                $('input[name="shipping_city"]').addClass('is-invalid');
                isValid = false;
                errorMessages.push('Please enter your city.');
            } else {
                $('input[name="shipping_city"]').removeClass('is-invalid');
            }
            
            // Validate pincode
            if ($('input[name="shipping_pincode"]').val().trim() === '') {
                $('input[name="shipping_pincode"]').addClass('is-invalid');
                isValid = false;
                errorMessages.push('Please enter your pincode.');
            } else {
                $('input[name="shipping_pincode"]').removeClass('is-invalid');
            }
            
            if (!isValid) {
                // Show error message
                if ($('.info-widget .alert-danger').length === 0) {
                    $('.info-widget').prepend('<div class="alert alert-danger"><ul class="mb-0"></ul></div>');
                }
                var $errorList = $('.info-widget .alert-danger ul');
                $errorList.empty();
                errorMessages.forEach(function(msg) {
                    $errorList.append('<li>' + msg + '</li>');
                });
                $('html, body').animate({
                    scrollTop: $('.alert-danger').offset().top - 100
                }, 500);
                return false;
            }

            return true;
        }

        $('#open-stripe-checkout').on('click', function(e) {
            e.preventDefault();

            if (!validateShippingForm()) {
                return;
            }

            var qty = ticketQty;
            var total = parseFloat(unitPrice * qty).toFixed(2);
            var totalInSmallestUnit = Math.round(parseFloat(total) * 100);

            if (qty < 1 || totalInSmallestUnit < 1) {
                alert('Invalid ticket quantity or amount.');
                return;
            }

            stripeHandler.open({
                name: 'Ticket Purchase',
                description: qty + ' ticket(s) - ' + total + ' {{ $data->currency_name }}',
                amount: totalInSmallestUnit,
                currency: "{{ strtolower($data->currency_name) }}",
                email: "{{ Auth::user()->email ?? '' }}"
            });
        });

        // Form validation before final submission (token callback submit)
        $('#payment-form').on('submit', function(e) {
            if (!validateShippingForm()) {
                e.preventDefault();
                return false;
            }
        });
        
        // Remove invalid class on input
        $('input, textarea, select').on('input change', function() {
            $(this).removeClass('is-invalid');
        });
        
        $('#country').on('change', function() {
            let countryId = $(this).val();
            $('#city').empty().append('<option value="">Loading...</option>');

            if (countryId) {
                $.ajax({
                    url: "{{ route('get.cities') }}",
                    type: "GET",
                    data: { country_id: countryId },
                    success: function(data) {
                        $('#city').empty().append('<option value="">Select</option>');
                        $.each(data, function(key, city) {
                            $('#city').append(`<option value="${city.id}">${city.city_name}</option>`);
                        });
                    },
                    error: function() {
                        alert('Unable to fetch cities. Please try again.');
                    }
                });
            } else {
                $('#city').empty().append('<option value="">Select</option>');
            }
        });
    });
    </script>

@endsection
