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
    <div class="content">
        <div class="container">

            <div class="row">
                <div class="col-md-4 col-lg-4 col-xl-3 theiaStickySidebar">

                    <!-- Profile Widget -->

                    <div class="card widget-profile pat-widget-profile">
                        <div class="card-body">
                            <div class="pro-widget-content">
                                <h4><b><a href="customer-profile">Time Remaining</a></b></h4>

                                @if($minutesDifference<15)
                                 {{-- {{ 15 - $minutesDifference }}   --}}
                                 <div><h2><span id="time">



                                </span></h2></div>
                                @else
                                <h1>Timer Ended</h1>
                                @endif
                                <div class="profile-det-info">

                                    {{-- <div class="customer-details"> --}}

                                        <h5 >
                                            Your Tickets are Reserved For 15 minutes for Purchasing..
                                            Please complete the purchase before the timer Ends..
                                        </h5>
                                    {{-- </div> --}}
                                    <a href="{{ url('release_my_tickets') }}" class="btn btn-danger">Relese My Holded Tickets</a>
                                </div>

                            </div>
                            {{-- <div class="customer-info">
										<ul>
											<li>Phone <span>+1 952 001 8563</span></li>
											<li>Age <span>38 Years, Male</span></li>
											<li>Event Name <span>Sangeet</span></li>
										</ul>
									</div> --}}
                        </div>
                    </div>
                    <!-- /Profile Widget -->
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
                                    <ul class="booking-date">
                                        <li>Date <span>{{ date('d M Y',strtotime($data->event_date)) }}</span></li>
                                        <li>Time <span>{{ date('H:i A',strtotime($data->event_time)) }}</span></li>
                                    </ul>
                                    <ul class="booking-fee">
                                        <li>Ticket Name <span>{{ Str::ucfirst($data->ticket_name) }}</span></li>
                                        <li>Number of Tickets <span>{{ $ticket_count }}</span></li>
                                        <li>Ticket Amount <span>{{ round($data->web_price) . $data->short_name }}</span></li>
                                        <li>Total Amount <span>{{ round($data->web_price * $ticket_count) . $data->short_name  }}</span></li>
                                    </ul>
                                    <div class="booking-total">
                                        <ul class="booking-total-list">
                                            <li>
                                                <span>Final Amount</span>
                                                <span class="total-cost">{{ round($data->web_price * $ticket_count) . $data->short_name  }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-8 col-lg-8 col-xl-9">
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
                            data-cc-on-file="false"
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

                                <input type="hidden" value="{{ round($data->web_price * $ticket_count) }}" name="payment_amount">
                                <input type="hidden" value="{{ $data->event_id }}" name="event_id">
                                <input type="hidden" value="{{ $data->id }}" name="event_ticket_id">
                                <input type="hidden" value="{{ $ticket_count }}" name="total_number">
                                <input type="hidden" value="{{ $data->currency_name }}" name="currency_name">

                                {{-- <input type="hidden" value="{{ round($data->web_price * $ticket_count) }}" name="payment_amount"> --}}



                                <div class="info-widget">
                                   <h4 class="card-title">Shipping Information</h4>
                                   <div class="row">
                                       <div class="col-md-6 col-sm-12">
                                           <div class="form-group card-label">
                                               <label>Name</label>
                                               <input class="form-control" name="shipping_name" value="{{ Auth::user()->name }}" type="text" required>
                                           </div>
                                       </div>
                                       <div class="col-md-6 col-sm-12">
                                           <div class="form-group card-label">
                                               <label>Address Line 1</label>
                                               <textarea class="form-control" name="shipping_address1" required>{{ Auth::user()->address }} </textarea>
                                           </div>
                                       </div>
                                       <div class="col-md-6 col-sm-12">
                                           <div class="form-group card-label">
                                               <label>Address Line 2</label>
                                               <textarea class="form-control" name="shipping_address2" > </textarea>
                                           </div>
                                       </div>
                                       <div class="col-md-6 col-sm-12">
                                           <div class="form-group card-label">
                                               <label>Country</label>
                                              <select class="form-control" name="shipping_country" required>

                                               <option value=""> select</option>
                                               @foreach ($countries as $country )

                                               <option value="{{ $country->id }}">{{ $country->country_name }}</option>

                                               @endforeach

                                              </select>
                                           </div>
                                       </div>
                                       <div class="col-md-6 col-sm-12">
                                           <div class="form-group card-label">
                                               <label>City</label>
                                               <input class="form-control"  required  type="text" name="shipping_city" >
                                           </div>
                                       </div>
                                       <div class="col-md-6 col-sm-12">
                                           <div class="form-group card-label">
                                               <label>Pincode</label>
                                               <input class="form-control" required type="text" name="shipping_pincode" >
                                           </div>
                                       </div>
                                   </div>

                                </div>



                                <!-- /Personal Information -->

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

                                    <script
        src="https://checkout.stripe.com/checkout.js"
        class="stripe-button"
        data-key="{{ config('services.stripe.key') }}"
        data-amount="{{ round($data->web_price * $ticket_count * 100) }}"
        data-locale="auto"
        data-currency="{{ strtolower($data->currency_name) }}"
    ></script>
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
        function startTimer(duration, display) {
            var timer = duration,
                minutes, seconds;
            setInterval(function() {
                minutes = parseInt(timer / 60, 10);
                seconds = parseInt(timer % 60, 10);

                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                display.textContent = minutes + ":" + seconds;

                if (--timer < 0) {
                    timer = duration;
                }

                if(--timer === 0){

                    location.reload();
                }
            }, 1000);
        }

        window.onload = function() {
            var fiveMinutes = 60 * (@php
                echo (15 - $minutesDifference)
            @endphp),
                display = document.querySelector('#time');
            startTimer(fiveMinutes, display);
        };
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script scr="http://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.2/js/toastr.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>

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
  alert($form);
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
            if (response.error)
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
