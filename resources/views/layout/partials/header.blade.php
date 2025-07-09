<?php
error_reporting(0);
?>
<style>
    @media (max-width: 991px) {
    .test {
        display: none!important;

    }
}
</style>

<!-- Loader -->
@if(Route::is(['map-grid','map-list']))
{{-- <div id="loader">
    <div class="loader">
        <span></span>
        <span></span>
    </div>
</div> --}}
@endif
<!-- /Loader -->

<!-- Main Wrapper -->
<div class="main-wrapper">
    @if(Route::is(['page']))
    <!-- Header -->
    <header class="header main-header">
    @endif
    @if(!Route::is(['page']))

    @endif

    {{-- <!-- Top Header -->
    <div class="top-header text-center">
        <h6 class="text-white">Just 4 Entertainment is a secondary market place for live events. All tickets are 100% guaranteed and secure. Prices are set by sellers and may be above or below face value.</h6>
    </div>
    <!-- /Top Header --> --}}

    @php
    $settings = \App\Models\CompanySettings::first();
    @endphp
    <header class="header">
    <!-- Navbar -->
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark test"  style="height: 82px;

    background: rgb(34,30,105);
    background: linear-gradient(90deg, rgba(34,30,105,1) 5%, rgba(54,8,94,1) 65%, rgba(103,29,207,1) 100%);
    " >
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ Storage::disk('image')->url('uploads/images/' . $settings->company_logo) }}" class="" width="300px;" height="70px;" alt="Logo">
            </a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">

    <form class="me-3" action="{{ url('/') }}" method="GET">
        <div class="input-group" style="width: 577px; ">
            <input type="search" class="form-control rounded-pill" style="border-radius: 30px; min-height: -webkit-fill-available;"
                placeholder="Event, Artist, Location" name="search" aria-label="Search" aria-describedby="search-addon"
                value="{{ $_GET['search'] }}" />
            <button type="submit" class="btn btn-primary rounded-pill ml-1">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </form>


                <ul class="navbar-nav ml-auto"> <!-- Use ml-auto to align items to the right -->
                    <li class="nav-item">

                        @php
                        if (Auth::user()) {
                            $check_cart = \App\Models\TicketsGenerated::where('user_id',Auth::user()->id)->where('is_sold',0)->first();

                        }else{
                            $check_cart = null;
                        }

                        @endphp

                        @if($check_cart)
                        <a class="nav-link" href="{{ route('customer_ticket_billing_page',$check_cart->event_tickets); }}">CART</a>
                        @endif
                    </li>
                    @if(!Auth::user())
                    <li class="nav-item">
                        <a class="nav-link login-button btn btn-primary btn-sm gradient-button" style="border-radius: 15px;padding:5px 30px 5px 30px;" href="{{ url('login') }}">Login</a>
                    </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link  btn btn-primary btn-sm  gradient-button1"  style="border-radius: 15px;padding:5px 9px 5px 9px; margin-left: 12px;"href="{{ url('sell_tickets') }}">Sell Tickets</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="{{ route('reseller.requestevent') }}"><u>Request Event</u></a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link facebook-button" href="#"target="_blank"><i class="fab fa-facebook-f"></i></a>

                    </li>
                    <li>

                    </li>
                    <li class="nav-item">
                        <a class="nav-link twitter-button" href="#" target="_blank"><i class="fab fa-twitter"></i></a>

                    </li>
                    <li class="nav-item">
                        <a class="nav-link instagram-button" href="#" target="_blank"><i class="fab fa-instagram"></i></a>
                    </li> --}}
                </ul>

            </div>
        </div>
        <div class="header-top-right">
            <!-- Your user menu HTML goes here -->
            <!-- For example, user menu with login/logout links -->
            @if(Auth::user()->id)
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
            <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                <span class="user-img">
                    <img class="rounded-circle" src="{{ asset('assets/img/speakers/speaker-thumb-02.jpg') }}" width="31">
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="user-header">
                    <div class="avatar avatar-sm">
                        <img src="{{ asset('assets/img/speakers/speaker-thumb-02.jpg') }}" alt="User Image" class="avatar-img rounded-circle">
                    </div>
                    <div class="user-text">
                        <h6>{{ ucfirst(Auth::user()->name) }}</h6>
                        <p class="text-muted mb-0">{{ ucfirst(Auth::user()->user_type) }}</p>
                    </div>
                </div>
                <a class="dropdown-item" href="{{ url('home') }}">Dashboard</a>
                <a class="dropdown-item" href="{{ url('profile-settings') }}">Profile Settings</a>
                <a class="dropdown-item" href="#"
                    onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">Logout</a>
            </div>
            <br>
            @endif
        </div>

    </nav>
    <!-- Navbar -->
    </header>
    <!-- Navbar -->

    <style>
        .form-white.input-group>.form-control:focus {
            border-color: #fff;
            box-shadow: inset 0 0 0 1px #fff;
        }

        .navbar-dark .navbar-nav .nav-link {
            color: #fff;
        }

        .navbar-dark .navbar-nav .nav-link:hover,
        .navbar-dark .navbar-nav .nav-link:focus {
            color: rgba(255, 255, 255, 0.75);
        }
    </style>

    {{-- <nav class="navbar navbar-expand-lg header-nav"
    @if(Request::path()=='/')
    style="background: rgb(34,30,105); background: linear-gradient(90deg, rgba(34,30,105,1) 5%, rgba(54,8,94,1) 65%, rgba(103,29,207,1) 100%);padding: 35px!important;"
    @else
    @endif>
        <div class="navbar-header">
            <a id="mobile_btn" href="javascript:void(0);">
                <span class="bar-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </a>
            <a id="mobile_btn" class="navbar-brand" href="{{ url('/') }}" style="margin-left:40px;">
                <img src="{{ Storage::disk('image')->url('uploads/images/' . $settings->company_logo) }}" class="" width="300px;" height="60px;" alt="Logo">
            </a>


            @php
            $settings = \App\Models\CompanySettings::first();
            @endphp
            {{-- <a href="index" class="navbar-brand logo">
                <img src="{{ Storage::disk('image')->url('uploads/images/' . $settings->company_logo) }}" class="" width="326" height="76" alt="Logo">
            </a> --}}
        </div>

        <div class="main-menu-wrapper col-12">
            <div class="menu-header">
                <a href="index">
                    <img src="assets/img/logoscroll.png" class="img-fluid" alt="Logo">
                </a>
                <a id="menu_close" class="menu-close" href="javascript:void(0);">
                    <i class="fas fa-times"></i>
                </a>
            </div>
            @php
            $eventtypes = \App\Models\EventType::where('is_active',1)->select('event_type_name','id')->get();
            @endphp

        </div>

        {{-- <div>
            <ul class="main-nav text-center"> <!-- Center-align text -->
                <li class="col-md-12">
                    <h6 class="text-white">Just 4 Entertainment is a secondary market place for live events. All tickets are 100% guaranteed and secure. Prices are set by sellers and may be above or below face value.</h6>
                </li>
            </ul>
            <div class="main-menu-wrapper" style="padding-left:450px;" >

                <div class="menu-header">
                    <a href="index">
                        <img src="assets/img/logoscroll.png" class="img-fluid" alt="Logo">
                    </a>
                    <a id="menu_close" class="menu-close" href="javascript:void(0);">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
                @php
                $eventtypes = \App\Models\EventType::where('is_active',1)->select('event_type_name','id')->get();
                @endphp

                <ul class="main-nav text-center"> <!-- Center-align text -->
                    @foreach ($eventtypes as $eventtype)
                    <li>

                        <a href="{{ url('/'.'?type='.$eventtype->id) }}">{{$eventtype->event_type_name.' Tickets'}}</a>



                    </li>
                    @endforeach
                </ul>
            </div>
        </div> --}}



        <!-- User Menu or Social Icons -->

    {{-- </nav> --}}
    <!-- /Header -->

    <style>
        .licenter {
            display: flex;
            justify-content: center;
        }
        <style>
    .login-button {
        background-color: rgb(174, 255, 0); /* Set your desired background color */
        color: white; /* Text color */
        padding: 10px 20px; /* Adjust padding as needed */
        border-radius: 20px; /* Rounded corners */
        border-color: white; /* Rounded corners */
        transition: background-color 0.3s ease; /* Smooth hover transition */
    }

    .login-button:hover {
        background-color: darkblue; /* Change the background color on hover */
    }

    .gradient-button {
    background-image: linear-gradient(to right, #001f3f, #117eea); /* Gradient colors */
    color: white; /* Text color */
    padding: 10px 20px; /* Adjust padding as needed */
    border: 1px solid white; /* Remove border */
    border-radius: 5px; /* Rounded corners */
    cursor: pointer; /* Change cursor on hover */
    transition: background-image 0.3s ease; /* Smooth hover transition */

}

.gradient-button:hover {
    background-image: linear-gradient(to right, #001f3f, #0074d9); /* Change the gradient on hover */
}





.gradient-button1 {
    background-image: linear-gradient(to right, #d900d2, #35042a); /* Gradient colors */
    color: white; /* Text color */
    padding: 10px 20px; /* Adjust padding as needed */
    border: 1px solid white ; /* Remove border */
    border-radius: 5px; /* Rounded corners */
    cursor: pointer; /* Change cursor on hover */
    transition: background-image 0.3s ease; /* Smooth hover transition */
}

.gradient-button1:hover {
    background-image: linear-gradient(to right, #d900d2, #5d084a); /* Change the gradient on hover */
}

.instagram-button {
    background-image: linear-gradient(to bottom, #8a3ab9, #ff2d55); /* Gradient colors */
    color: white; /* Text color */
    display: inline-flex; /* Display as a flex container */
    align-items: center; /* Center the icon and text vertically */
    justify-content: center; /* Center the icon and text horizontally */
    /* padding: 10px 20px; Adjust padding as needed */
    border-radius: 15px; /* Rounded corners */
    cursor: pointer; /* Change cursor on hover */
    transition: background-image 0.3s ease; /* Smooth hover transition */
    text-decoration: none; /* Remove underline from the link */
    padding:5px 9px 5px 9px;
    border:1px solid white;
}

.instagram-button:hover {
    background-image: linear-gradient(to bottom, #ff2d55, #8a3ab9); /* Change the gradient on hover */
}

.facebook-button {
    background-image: linear-gradient(to bottom, #8a3ab9, #ff2d55); /* Gradient colors */
    color: white; /* Text color */
    display: inline-flex; /* Display as a flex container */
    align-items: center; /* Center the icon and text vertically */
    justify-content: center; /* Center the icon and text horizontally */
    /* padding: 10px 20px; Adjust padding as needed */
    border-radius: 15px; /* Rounded corners */
    cursor: pointer; /* Change cursor on hover */
    transition: background-image 0.3s ease; /* Smooth hover transition */
    text-decoration: none; /* Remove underline from the link */
    padding:5px 9px 5px 9px;
    margin-left: 18px;
    border:1px solid white;
}

.facebook-button:hover {
    background-image: linear-gradient(to bottom, #ff2d55, #8a3ab9); /* Change the gradient on hover */
}


.twitter-button {
    background-image: linear-gradient(to bottom, #8a3ab9, #ff2d55); /* Gradient colors */
    color: white; /* Text color */
    display: inline-flex; /* Display as a flex container */
    align-items: center; /* Center the icon and text vertically */
    justify-content: center; /* Center the icon and text horizontally */
    /* padding: 10px 20px; Adjust padding as needed */
    border-radius: 15px; /* Rounded corners */
    cursor: pointer; /* Change cursor on hover */
    transition: background-image 0.3s ease; /* Smooth hover transition */
    text-decoration: none; /* Remove underline from the link */
    margin: 0px 5px 0px 5px;
    padding:5px 9px 5px 9px;
    border:1px solid white;
}

.twitter-button:hover {
    background-image: linear-gradient(to bottom, #ff2d55, #8a3ab9); /* Change the gradient on hover */
}

.carousel-control-next {
    /* right: 0; */
    top: 139px!important;
}
.carousel-control-prev {
    /* left: 0; */
    top: 139px!important;

}

</style>


</div>
