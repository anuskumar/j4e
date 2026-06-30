<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
    <meta name="Author" content="Spruko Technologies Private Limited">
    <meta name="Keywords"
        content="admin,admin dashboard,admin dashboard template,admin panel template,admin template,admin theme,bootstrap 4 admin template,bootstrap 4 dashboard,bootstrap admin,bootstrap admin dashboard,bootstrap admin panel,bootstrap admin template,bootstrap admin theme,bootstrap dashboard,bootstrap form template,bootstrap panel,bootstrap ui kit,dashboard bootstrap 4,dashboard design,dashboard html,dashboard template,dashboard ui kit,envato templates,flat ui,html,html and css templates,html dashboard template,html5,jquery html,premium,premium quality,sidebar bootstrap 4,template admin bootstrap 4" />

    <!-- Title -->
    <title>Admin Dashboard </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!--- Favicon --->
    <link rel="icon" href="{{ $appLogoUrl }}" type="image/jpeg" />

    <!-- Bootstrap css -->
    <link href="{{ asset('admin_assets/plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet" id="style" />

    <!--- Style css --->
    <link href="{{ asset('admin_assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('admin_assets/css/plugins.css') }}" rel="stylesheet">

    <!--- Icons css --->
    <link href="{{ asset('admin_assets/css/icons.css') }}" rel="stylesheet">

    <!--- Animations css --->
    <link href="{{ asset('admin_assets/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/toastr.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/summernote.min.css') }}" rel="stylesheet">
    <style>
        .loader {
            border: 16px solid #f3f3f3;
            /* Light grey */
            border-top: 16px solid #3498db;
            /* Blue */
            border-radius: 50%;
            width: 120px;
            height: 120px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .hide-loader {
            display: none;
        }

        .notification-count-badge {
            position: absolute;
            top: 8px;
            right: 4px;
            min-width: 18px;
            height: 18px;
            padding: 0 5px;
            border-radius: 10px;
            background: #ff473d;
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            line-height: 18px;
            text-align: center;
        }
        
        /* Ensure Feather icons are visible */
        .side-menu__icon,
        .fe {
            display: inline-block;
            font-family: 'feather' !important;
            speak: none;
            font-style: normal;
            font-weight: normal;
            font-variant: normal;
            text-transform: none;
            line-height: 1;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        
        /* Ensure icons show when sidebar items are clicked */
        .side-menu__item i,
        .slide-menu .sub-side-menu__item i {
            opacity: 1 !important;
            visibility: visible !important;
        }
        
        /* Fix for collapsed sidebar */
        .sidebar-mini .side-menu__icon {
            display: inline-block !important;
        }
    </style>
</head>
@php
    $system = \App\Models\CompanySettings::first();
@endphp

<body class="main-body app sidebar-mini ltr">

    <!-- Loader -->
    <div id="global-loader">
        <img src="{{ asset('admin_assets/img/loaders/loader-4.svg') }}" class="loader-img" alt="Loader">
    </div>
    <!-- /Loader -->

    <!-- page -->
    <div class="page custom-index">

        <!-- main-header -->
        <div class="main-header side-header sticky nav nav-item">
            <div class="container-fluid main-container ">
                <div class="main-header-left ">
                    <div class="app-sidebar__toggle mobile-toggle" data-bs-toggle="sidebar">
                        <a class="open-toggle" href="javascript:void(0);"><i class="header-icons"
                                data-eva="menu-outline"></i></a>
                        <a class="close-toggle" href="javascript:void(0);"><i class="header-icons"
                                data-eva="close-outline"></i></a>
                    </div>
                    <div class="responsive-logo">
                        <a href="{{ route('admin.home') }}" class="header-logo"><img
                                src="{{ $appLogoUrl }}" class="logo-11" alt="logo"></a>
                        <a href="{{ route('admin.home') }}" class="header-logo">
                            <img src="{{ $appLogoUrl }}" class="logo-1" alt="logo">
                        </a>

                    </div>
                    <ul class="header-megamenu-dropdown  nav">
                        {{-- <li class="nav-item">
								<div class="btn-group dropdown">
									<button aria-expanded="false" aria-haspopup="true" class="btn btn-link dropdown-toggle" data-bs-toggle="dropdown" id="dropdownMenuButton2" type="button"><span><i class="fe fe-settings"></i> Settings </span></button>
									<div  class="dropdown-menu" >
										<div class="dropdown-menu-header header-img p-3">
											<div class="drop-menu-inner">
												<div class="header-content text-start d-flex">
												    <div class="text-white">
														<h5 class="menu-header-title">Setting</h5>
														<h6 class="menu-header-subtitle mb-0">Overview of theme</h6>
													</div>
													<div class="my-auto ms-auto">
														<span class="badge bg-pill bg-warning float-end">View all</span>
													</div>
												</div>
											</div>
										</div>
										<div class="setting-scroll">
											<div>
												<div class="setting-menu ">
													<a  class="dropdown-item"   href="profile.html"><i class="mdi mdi-account-outline tx-16 me-2 mt-1"></i>Profile</a>
													<a class="dropdown-item"   href="contacts.html"><i class="mdi mdi-account-box-outline tx-16 me-2"></i>Contacts</a>
													<a class="dropdown-item"   href="settings.html"><i class="mdi mdi-account-location tx-16 me-2"></i>Accounts</a>
													<div class="dropdown-divider"></div>
													<a class="dropdown-item"   href="about.html"><i class="typcn typcn-briefcase tx-16 me-2"></i>About us</a>
													<a class="dropdown-item"   href="javascript:void(0);"><i class="mdi mdi-application tx-16 me-2"></i>Getting start</a>
												</div>
											</div>
										</div>
										<ul class="setting-menu-footer flex-column ps-0">
											<li class="divider mb-0 pb-0 "></li>
											<li class="setting-menu-btn">
												<button class=" btn-shadow btn btn-success btn-sm">Cancel</button>
											</li>
										</ul>
									</div>
								</div>
							</li> --}}
                        {{-- <li class="nav-item">
								<div class="dropdown-menu-rounded btn-group dropdown" >
									<button aria-expanded="false" aria-haspopup="true" class="btn btn-link dropdown-toggle" data-bs-toggle="dropdown" id="dropdownMenuButton3" type="button"><span><i class="nav-link-icon fe fe-briefcase"></i> Projects </span></button>
									<div class="dropdown-menu-lg dropdown-menu"  x-placement="bottom-left">
										<div class="dropdown-menu-header">
											<div class="dropdown-menu-header-inner header-img p-3">
												<div class="header-content text-start d-flex">
												    <div class="text-white">
														<h5 class="menu-header-title">Projects</h5>
														<h6 class="menu-header-subtitle mb-0">Overview of Projects</h6>
													</div>
													<div class="my-auto ms-auto">
														<span class="badge bg-pill bg-warning float-end">View all</span>
													</div>
												</div>
											</div>
										</div>
										<a  class="dropdown-item  mt-2"   href="javascript:void(0);"><i class="dropdown-icon"></i>Mobile Application</a>
										<a class="dropdown-item"   href="javascript:void(0);"><i class="dropdown-icon"></i>PSD Projects</a>
										<a class="dropdown-item"   href="javascript:void(0);"><i class="dropdown-icon"></i>PHP Project</a>
										<div class="dropdown-divider"></div>
										<a class="dropdown-item"   href="javascript:void(0);"><i class="dropdown-icon"></i>Wordpress Projects</a>
										<a class="dropdown-item mb-2"   href="javascript:void(0);"><i class="dropdown-icon "></i>HTML & CSS3 Projects</a>
									</div>
								</div>
							</li> --}}
                    </ul>
                </div>
                <button class="navbar-toggler nav-link icon navresponsive-toggler vertical-icon ms-auto" type="button"
                    data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent-4"
                    aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fe fe-more-vertical header-icons navbar-toggler-icon"></i>
                </button>
                <div
                    class="mb-0 navbar navbar-expand-lg navbar-nav-right responsive-navbar navbar-dark p-0  mg-lg-s-auto">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
                        <div class="main-header-right">
                            <div class="nav nav-item nav-link" id="bs-example-navbar-collapse-1">
                                <form class="navbar-form" role="search">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search">
                                        <span class="input-group-btn">
                                            <button type="reset" class="btn btn-default">
                                                <i class="fas fa-times"></i>
                                            </button>
                                            <button type="submit" class="btn btn-default nav-link">
                                                <i class="fe fe-search"></i>
                                            </button>
                                        </span>
                                    </div>
                                </form>
                            </div>
                            <li class="dropdown nav-item main-layout">
                                <a class="new theme-layout nav-link-bg layout-setting">
                                    <span class="dark-layout"><i class="fe fe-moon"></i></span>
                                    <span class="light-layout"><i class="fe fe-sun"></i></span>
                                </a>
                            </li>
                            <div class="nav nav-item  navbar-nav-right mg-lg-s-auto">
                                <div class="nav-item full-screen fullscreen-button">
                                    <a class="new nav-link full-screen-link" href="javascript:void(0);"><i
                                            class="fe fe-maximize"></i></span></a>
                                </div>
                                {{-- <div class="dropdown  nav-item main-header-message ">
										<a class="new nav-link"   href="javascript:void(0);" ><i class="fe fe-mail"></i><span class=" pulse-danger"></span></a>
										<div class="dropdown-menu">
											<div class="menu-header-content bg-primary-gradient text-start d-flex">
										    		<div class="">
													<h6 class="menu-header-title text-white mb-0">5 new Messages</h6>
												</div>
												<div class="my-auto mg-s-auto">
													<a class="badge bg-pill bg-warning float-end"   href="javascript:void(0);">Mark All Read</a>
												</div>
											</div>
											<div class="main-message-list chat-scroll">
												<a href="mail.html" class="p-3 d-flex border-bottom">
													<div class="drop-img  cover-image  " data-bs-image-src="{{ asset('admin_assets/img/faces/3.jpg') }}">
														<span class="avatar-status bg-teal"></span>
													</div>

													<div class="wd-90p">
														<div class="d-flex">
															<h5 class="mb-1 name">Paul Molive</h5>
															<p class="time mb-0 text-end ms-auto float-end">10 min ago</p>
														</div>
														<p class="mb-0 desc">I'm sorry but i'm not sure how...</p>
													</div>
												</a>
												<a href="mail.html" class="p-3 d-flex border-bottom">
													<div class="drop-img cover-image" data-bs-image-src="{{ asset('admin_assets/img/faces/2.jpg') }}">
														<span class="avatar-status bg-teal"></span>
													</div>
													<div class="wd-90p">
														<div class="d-flex">
															<h5 class="mb-1 name">Sahar Dary</h5>
															<p class="time mb-0 text-end ms-auto float-end">13 min ago</p>
														</div>
														<p class="mb-0 desc">All set ! Now, time to get to you now......</p>
													</div>
												</a>
												<a href="mail.html" class="p-3 d-flex border-bottom">
													<div class="drop-img cover-image" data-bs-image-src="{{ asset('admin_assets/img/faces/9.jpg') }}">
														<span class="avatar-status bg-teal"></span>
													</div>
													<div class="wd-90p">
														<div class="d-flex">
															<h5 class="mb-1 name">Khadija Mehr</h5>
															<p class="time mb-0 text-end ms-auto float-end">20 min ago</p>
														</div>
														<p class="mb-0 desc">Are you ready to pickup your Delivery...</p>
													</div>
												</a>
												<a href="mail.html" class="p-3 d-flex border-bottom">
													<div class="drop-img cover-image" data-bs-image-src="{{ asset('admin_assets/img/faces/12.jpg') }}">
														<span class="avatar-status bg-danger"></span>
													</div>
													<div class="wd-90p">
														<div class="d-flex">
															<h5 class="mb-1 name">Barney Cull</h5>
															<p class="time mb-0 text-end ms-auto float-end">30 min ago</p>
														</div>
														<p class="mb-0 desc">Here are some products ...</p>
													</div>
												</a>
												<a href="mail.html" class="p-3 d-flex border-bottom">
													<div class="drop-img cover-image" data-bs-image-src="{{ asset('admin_assets/img/faces/5.jpg') }}">
														<span class="avatar-status bg-teal"></span>
													</div>
													<div class="wd-90p">
														<div class="d-flex">
															<h5 class="mb-1 name">Petey Cruiser</h5>
															<p class="time mb-0 text-end ms-auto float-end">35 min ago</p>
														</div>
														<p class="mb-0 desc">I'm sorry but i'm not sure how...</p>
													</div>
												</a>
											</div>
											<div class="text-center dropdown-footer">
												<a href="mail.html">VIEW ALL</a>
											</div>
										</div>
									</div> --}}
                                @include('admin.layout.partials.notifications')
                                @php
                                    $authProfileImage = Auth::user()->profileImageUrl();
                                @endphp
                                <div class="dropdown main-profile-menu nav nav-item nav-link">
                                    <a class="profile-user d-flex" href=""><img
                                            src="{{ $authProfileImage }}" alt="user-img"
                                            class="rounded-circle mCS_img_loaded"
                                            onerror="this.src='{{ asset('admin_assets/img/faces/6.jpg') }}'"><span></span></a>

                                    <div class="dropdown-menu">
                                        <div class="main-header-profile header-img">
                                            <div class="main-img-user"><img alt=""
                                                    src="{{ $authProfileImage }}"
                                                    onerror="this.src='{{ asset('admin_assets/img/faces/6.jpg') }}'"></div>
                                            <h6>{{ ucfirst(Auth::user()->name) }}</h6>
                                            <span>{{ ucfirst(Auth::user()->user_type) }}</span>
                                        </div>
                                        <a class="dropdown-item" href="{{ route('reseller.profile') }}"><i
                                                class="far fa-user"></i> My Profile</a>
                                        {{-- <a class="dropdown-item" href="profile.html"><i class="far fa-edit"></i> Edit Profile</a> --}}
                                        {{-- <a class="dropdown-item" href="profile.html"><i class="far fa-clock"></i> Activity Logs</a> --}}
                                        <!-- <a class="dropdown-item" href="profile.html"><i class="fas fa-sliders-h"></i>
                                            Account Settings</a> -->
                                        @if (Auth::user()->user_type == 'superadmin')
                                            <a class="dropdown-item" href="{{ url('admin/company_settings') }}"><i
                                                    class="fas fa-sliders-h"></i> Company Settings</a>
                                            <a class="dropdown-item" href="{{ route('admin.paypal.settings') }}"><i
                                                    class="fas fa-credit-card"></i> PayPal Integration</a>
                                            <a class="dropdown-item" href="{{ route('admin.bulk-email.index') }}"><i
                                                    class="fas fa-envelope"></i> Sent Emails</a>
                                        @endif

                                        <a class="dropdown-item" href="#"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fas fa-sign-out-alt"></i> Logout
                                        </a>
                                    </div>
                                </div>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                                {{-- <div class="dropdown main-header-message right-toggle">
										<a class="nav-link pe-0" data-bs-toggle="sidebar-right" data-bs-target=".sidebar-right">
											<i class="ion ion-md-menu tx-20 bg-transparent"></i>
										</a>
									</div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /main-header -->

        <!-- main-sidebar -->
        @if (Auth::user()->user_type == 'reseller')
            @include('admin.layout.reseller_sidebar')
        @else
            @include('admin.layout.sidebar')
        @endif
        <!-- main-sidebar -->

        <!-- main-content -->
        <div class="main-content app-content">

            <!-- container -->
            <div class="main-container container-fluid">

                <!-- breadcrumb -->
                <div class="breadcrumb-header justify-content-between">
                    <div>
                        <h4 class="content-title mb-2">@yield('page_title', 'Hi, welcome back!')</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                @hasSection('breadcrumbs')
                                    @yield('breadcrumbs')
                                @else
                                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Home</li>
                                @endif
                            </ol>
                        </nav>
                    </div>
                    <div class="d-flex my-auto">
                        <div class="d-flex right-page">
                            @hasSection('breadcrumb_stats')
                                @yield('breadcrumb_stats')
                            @endif
                        </div>
                    </div>
                </div>
                <!-- /breadcrumb -->

                <!-- main-content-body -->
                @yield('admin_content')
                <!-- /row -->
            </div>
            <!-- /container -->
        </div>
        <!-- /main-content -->

        <!--Sidebar-right-->
        <div class="sidebar sidebar-right sidebar-animate">
            <div class="panel panel-primary card mb-0">
                <div class="panel-body tabs-menu-body p-0 border-0">
                    <ul class="Date-time">
                        <li class="time">
                            <h1 class="animated ">21:00</h1>
                            <p class="animated ">Sat,October 1st 2029</p>
                        </li>
                    </ul>
                    <div class="card-body latest-tasks">
                        <h3 class="events-title"><span>Events For Week </span></h3>
                        <div class="event">
                            <div class="Day">Monday 20 Jan</div>
                            <a href="javascript:void(0);">No Events Today</a>
                        </div>
                        <div class="event">
                            <div class="Day">Tuesday 21 Jan</div>
                            <a href="javascript:void(0);">No Events Today</a>
                        </div>
                        <div class="event">
                            <div class="Day">Wednessday 22 Jan</div>
                            <div class="tasks">
                                <div class=" task-line primary">
                                    <a href="javascript:void(0);" class="label">
                                        XML Import &amp; Export
                                    </a>
                                    <div class="time">
                                        12:00 PM
                                    </div>
                                </div>
                                <div class="checkbox">
                                    <label class="check-box">
                                        <label class="ckbox"><input checked=""
                                                type="checkbox"><span></span></label>
                                    </label>
                                </div>
                            </div>
                            <div class="tasks">
                                <div class="task-line danger">
                                    <a href="javascript:void(0);" class="label">
                                        Connect API to pages
                                    </a>
                                    <div class="time">
                                        08:00 AM
                                    </div>
                                </div>
                                <div class="checkbox">
                                    <label class="check-box">
                                        <label class="ckbox"><input type="checkbox"><span></span></label>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="event">
                            <div class="Day">Thursday 23 Jan</div>
                            <div class="tasks">
                                <div class="task-line success">
                                    <a href="javascript:void(0);" class="label">
                                        Create Wireframes
                                    </a>
                                    <div class="time">
                                        06:20 PM
                                    </div>
                                </div>
                                <div class="checkbox">
                                    <label class="check-box">
                                        <label class="ckbox"><input type="checkbox"><span></span></label>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="event">
                            <div class="Day">Friday 24 Jan</div>
                            <div class="tasks">
                                <div class="task-line warning">
                                    <a href="javascript:void(0);" class="label">
                                        Test new features in tablets
                                    </a>
                                    <div class="time">
                                        02: 00 PM
                                    </div>
                                </div>
                                <div class="checkbox">
                                    <label class="check-box">
                                        <label class="ckbox"><input type="checkbox"><span></span></label>
                                    </label>
                                </div>
                            </div>
                            <div class="tasks">
                                <div class="task-line teal">
                                    <a href="javascript:void(0);" class="label">
                                        Design Evommerce
                                    </a>
                                    <div class="time">
                                        10: 00 PM
                                    </div>
                                </div>
                                <div class="checkbox">
                                    <label class="check-box">
                                        <label class="ckbox"><input type="checkbox"><span></span></label>
                                    </label>
                                </div>
                            </div>
                            <div class="tasks mb-0">
                                <div class="task-line purple">
                                    <a href="javascript:void(0);" class="label">
                                        Fix Validation Issues
                                    </a>
                                    <div class="time">
                                        12: 00 AM
                                    </div>
                                </div>
                                <div class="checkbox">
                                    <label class="check-box">
                                        <label class="ckbox"><input type="checkbox"><span></span></label>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex pagination wd-100p">
                            <a href="javascript:void(0);">Previous</a>
                            <a href="javascript:void(0);" class="ms-auto">Next</a>
                        </div>
                    </div>
                    <div class="card-body border-top border-bottom">
                        <div class="row">
                            <div class="col-4 text-center">
                                <a class="" href=""><i
                                        class="dropdown-icon mdi  mdi-message-outline fs-20 m-0 leading-tight"></i></a>
                                <div>Inbox</div>
                            </div>
                            <div class="col-4 text-center">
                                <a class="" href=""><i
                                        class="dropdown-icon mdi mdi-tune fs-20 m-0 leading-tight"></i></a>
                                <div>Settings</div>
                            </div>
                            <div class="col-4 text-center">
                                <a class="" href=""><i
                                        class="dropdown-icon mdi mdi-logout-variant fs-20 m-0 leading-tight"></i></a>
                                <div>Sign out</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/Sidebar-right-->
        <!-- Footer closed -->
    </div>

    </div>
    <!-- page closed -->

    <!--- Back-to-top --->
    <a href="#top" id="back-to-top"><i class="las la-angle-double-up"></i></a>
    <!--- JQuery min js --->
    <script src="{{ asset('admin_assets/js/summernote.min.js') }}"></script>
    <script src="{{ asset('admin_assets/plugins/jquery/jquery.min.js') }}"></script>

    @stack('scripts')

    <!--- Datepicker js --->
    <script src="{{ asset('admin_assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>

    <!--- Bootstrap Bundle js --->
    <script src="{{ asset('admin_assets/plugins/bootstrap/popper.min.js') }}"></script>
    <script src="{{ asset('admin_assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>

    <!--- Ionicons js --->
    <script src="{{ asset('admin_assets/plugins/ionicons/ionicons.js') }}"></script>

    <!--- Chart bundle min js --->
    <script src="{{ asset('admin_assets/plugins/chart.js/Chart.bundle.min.js') }}"></script>

    <!--- Sparkline fallback - must be defined BEFORE sparkline plugin loads --->
    <script>
        // Define sparkline fallback immediately to prevent errors
        (function() {
            if (typeof jQuery !== 'undefined') {
                // Store original if it exists, otherwise create fallback
                var originalSparkline = jQuery.fn.sparkline;
                jQuery.fn.sparkline = function() {
                    // If original exists and is a function, use it
                    if (typeof originalSparkline === 'function') {
                        return originalSparkline.apply(this, arguments);
                    }
                    // Otherwise return this to allow chaining
                    return this;
                };
            }
        })();
    </script>
    
    <!--- JQuery sparkline js --->
    <script src="{{ asset('admin_assets/plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
    
    <!--- Ensure sparkline is available after plugin loads --->
    <script>
        // Re-check and ensure sparkline is available after plugin loads
        (function() {
            if (typeof jQuery !== 'undefined') {
                if (typeof jQuery.fn.sparkline === 'undefined') {
                    jQuery.fn.sparkline = function() { 
                        return this; 
                    };
                }
            }
        })();
    </script>

    <!--- Internal Sampledata js --->
    <script src="{{ asset('admin_assets/js/chart.flot.sampledata.js') }}"></script>

    <!--- Eva-icons js --->
    <script src="{{ asset('admin_assets/js/eva-icons.min.js') }}"></script>

    <!--- Moment js --->
    <script src="{{ asset('admin_assets/plugins/moment/moment.js') }}"></script>

    <!--- Perfect-scrollbar js --->
    <script src="{{ asset('admin_assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('admin_assets/plugins/perfect-scrollbar/p-scroll.js') }}"></script>

    <!--- Sidebar js --->
    <script src="{{ asset('admin_assets/plugins/side-menu/sidemenu.js') }}"></script>
    <script>
        (function () {
            function normalizePath(path) {
                var normalized = (path || '').replace(/\/$/, '');
                return normalized || '/';
            }

            function pathBelongsToMenuItem(currentPath, linkPath) {
                currentPath = normalizePath(currentPath);
                linkPath = normalizePath(linkPath);

                if (currentPath === linkPath) {
                    return { matched: true, score: 10000 + linkPath.length };
                }

                var linkParts = linkPath.split('/').filter(Boolean);
                var currentParts = currentPath.split('/').filter(Boolean);

                if (!linkParts.length || linkParts[0] !== currentParts[0]) {
                    return { matched: false, score: 0 };
                }

                var moduleRoots = [
                    'eventtype', 'eventtags', 'currency', 'venue', 'slide',
                    'artistfield', 'venuetype', 'location', 'city',
                    'ticket_restrictions', 'artist'
                ];

                if (moduleRoots.indexOf(linkParts[0]) !== -1) {
                    return { matched: true, score: linkPath.length };
                }

                if (linkParts[0] === 'events') {
                    if (linkParts[1] === 'requestlist') {
                        return { matched: currentParts[1] === 'requestlist', score: linkPath.length };
                    }
                    if (linkParts[1] === 'list') {
                        return { matched: currentParts[1] !== 'requestlist', score: linkPath.length };
                    }
                }

                if (linkParts[0] === 'admin' && currentParts[0] === 'admin' && linkParts[linkParts.length - 1] === 'list') {
                    var prefixLength = linkParts.length - 1;
                    if (currentParts.length >= prefixLength) {
                        var prefixMatches = true;
                        for (var i = 0; i < prefixLength; i++) {
                            if (linkParts[i] !== currentParts[i]) {
                                prefixMatches = false;
                                break;
                            }
                        }
                        if (prefixMatches) {
                            return { matched: true, score: linkPath.length };
                        }
                    }
                }

                if (linkParts[0] === 'customer_order' && currentParts[0] === 'customer_order' && linkParts[1]) {
                    return { matched: linkParts[1] === currentParts[1], score: linkPath.length };
                }

                if (linkPath === '/tickets' && currentPath.indexOf('/tickets') === 0) {
                    return { matched: true, score: linkPath.length };
                }

                return { matched: false, score: 0 };
            }

            function applyActiveSidebarLink($link) {
                $link.addClass('active');

                if ($link.hasClass('slide-item')) {
                    $link.closest('.slide-menu').addClass('open').show();
                    $link.closest('.slide').addClass('is-expanded');
                    $link.closest('.slide').children('a.side-menu__item[data-bs-toggle="slide"]').addClass('active');
                } else if ($link.hasClass('sub-side-menu__item')) {
                    $link.closest('.sub-slide-menu').addClass('open').show();
                    $link.closest('.sub-slide').addClass('is-expanded');
                    $link.closest('.slide-menu').addClass('open').show();
                    $link.closest('.slide').addClass('is-expanded');
                    $link.closest('.slide').children('a.side-menu__item[data-bs-toggle="slide"]').addClass('active');
                    $link.closest('.sub-slide').children('a.slide-item[data-bs-toggle="sub-slide"]').addClass('active');
                } else if ($link.hasClass('side-menu__item') && !$link.attr('data-bs-toggle')) {
                    $link.closest('.slide').addClass('is-expanded');
                }

                if ($link.hasClass('slide-item') || $link.hasClass('sub-side-menu__item')) {
                    var $sidebar = jQuery('.app-sidebar');
                    if ($sidebar.length && $link.offset()) {
                        $sidebar.animate({
                            scrollTop: $link.offset().top - 600
                        }, 300);
                    }
                }
            }

            function activateSidebarMenu() {
                if (typeof jQuery === 'undefined') {
                    return;
                }

                var currentPath = normalizePath(window.location.pathname);
                var $bestLink = null;
                var bestScore = 0;

                jQuery('.side-menu .slide').removeClass('is-expanded');
                jQuery('.side-menu .sub-slide').removeClass('is-expanded');
                jQuery('.side-menu .slide-menu, .side-menu .sub-slide-menu').removeClass('open').css('display', '');
                jQuery('.side-menu a').removeClass('active');

                jQuery('.side-menu a[href]').each(function () {
                    var href = jQuery(this).attr('href');
                    if (!href || href.indexOf('javascript') === 0) {
                        return;
                    }

                    var linkPath;
                    try {
                        linkPath = normalizePath(new URL(href, window.location.origin).pathname);
                    } catch (e) {
                        return;
                    }

                    var result = pathBelongsToMenuItem(currentPath, linkPath);
                    if (result.matched && result.score > bestScore) {
                        bestScore = result.score;
                        $bestLink = jQuery(this);
                    }
                });

                if ($bestLink && $bestLink.length) {
                    applyActiveSidebarLink($bestLink);
                }
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', activateSidebarMenu);
            } else {
                activateSidebarMenu();
            }
        })();
    </script>

    <!--- sticky js --->
    <script src="{{ asset('admin_assets/js/sticky.js') }}"></script>

    <!-- right-sidebar js -->
    <script src="{{ asset('admin_assets/plugins/sidebar/sidebar.js') }}"></script>
    <script src="{{ asset('admin_assets/plugins/sidebar/sidebar-custom.js') }}"></script>
    
    <!--- Ensure icons are visible after sidebar interactions --->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Force icon visibility on page load
            function ensureIconsVisible() {
                const icons = document.querySelectorAll('.fe, .side-menu__icon, i[class*="fe-"]');
                icons.forEach(function(icon) {
                    icon.style.display = 'inline-block';
                    icon.style.opacity = '1';
                    icon.style.visibility = 'visible';
                    icon.style.fontSize = icon.style.fontSize || '16px';
                });
            }
            
            // Run immediately
            ensureIconsVisible();
            
            // Run after a short delay to ensure DOM is ready
            setTimeout(ensureIconsVisible, 100);
            setTimeout(ensureIconsVisible, 500);
            
            // Re-initialize icons when sidebar is toggled
            const sidebarToggle = document.querySelector('[data-bs-toggle="sidebar"]');
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    setTimeout(ensureIconsVisible, 300);
                });
            }
            
            // Re-initialize icons when menu items are clicked
            const menuItems = document.querySelectorAll('.side-menu__item, .sub-side-menu__item');
            menuItems.forEach(function(item) {
                item.addEventListener('click', function() {
                    setTimeout(ensureIconsVisible, 100);
                });
            });
            
            // Watch for sidebar state changes
            const observer = new MutationObserver(function(mutations) {
                ensureIconsVisible();
            });
            
            const sidebar = document.querySelector('.app-sidebar');
            if (sidebar) {
                observer.observe(sidebar, {
                    attributes: true,
                    attributeFilter: ['class']
                });
            }
        });
    </script>

    <!-- Morris js -->
    <script src="{{ asset('admin_assets/plugins/raphael/raphael.min.js') }}"></script>
    <script src="{{ asset('admin_assets/plugins/morris.js/morris.min.js') }}"></script>

    <!--- Scripts js --->
    <script src="{{ asset('admin_assets/js/script.js') }}"></script>

    <!--- Ensure sparkline is available before index.js runs --->
    <script>
        // Final check before index.js loads - ensure sparkline exists
        (function() {
            if (typeof jQuery !== 'undefined') {
                if (typeof jQuery.fn.sparkline === 'undefined' || typeof jQuery.fn.sparkline !== 'function') {
                    jQuery.fn.sparkline = function(options, callback) {
                        // No-op function that returns the jQuery object for chaining
                        return this;
                    };
                }
            }
        })();
    </script>

    <!--- Index js --->
    <script src="{{ asset('admin_assets/js/index.js') }}" onerror="console.warn('index.js failed to load');"></script>

    <!--themecolor js-->
    <script src="{{ asset('admin_assets/js/themecolor.js') }}"></script>

    <!--swither-styles js-->
    <script src="{{ asset('admin_assets/js/swither-styles.js') }}"></script>

    <!--- Custom js --->
    <script src="{{ asset('admin_assets/js/custom.js') }}"></script>

    <script src="{{ asset('assets/js/toastr.min.js') }}"></script>

    {{-- <script src="{{ asset('admin_assets/plugins/jquery/jquery.min.js') }}"></script> --}}

    <script src="{{ asset('/') }}assets/plugins/plugins/fileuploads/js/fileupload.js"></script>
    <script src="{{ asset('/') }}assets/plugins/plugins/fileuploads/js/file-upload.js"></script>

    <!--- Fancy uploader js --->
    <script src="{{ asset('/') }}assets/plugins/plugins/fancyuploder/jquery.ui.widget.js"></script>
    <script src="{{ asset('/') }}assets/plugins/plugins/fancyuploder/jquery.fileupload.js"></script>
    <script src="{{ asset('/') }}assets/plugins/plugins/fancyuploder/jquery.iframe-transport.js"></script>
    <script src="{{ asset('/') }}assets/plugins/plugins/fancyuploder/jquery.fancy-fileupload.js"></script>
    <script src="{{ asset('/') }}assets/plugins/plugins/fancyuploder/fancy-uploader.js"></script>


    {{-- modal js --}}
    {{-- <script src="sweetalert2.all.min.js"></script>
        <script src="admin_assets/js/main.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
        integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
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
    </script>

    <script type="text/javascript">
        $('.show_confirm').click(function(event) {
            var form = $(this).closest("form");
            var name = $(this).data("name");
            event.preventDefault();
            swal({
                    title: `Are you sure you want to delete this record?`,
                    text: "If you delete this, it will be gone forever.",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                    }
                });
        });

        @if (count($errors) > 0)

            @foreach ($errors->all() as $error)

                toastr.error("{{ $error }}");
            @endforeach
        @endif
    </script>

    <script>
        // Ensure logout functionality works
        $(document).ready(function() {
            // Handle logout clicks
            $('a[href="{{ route('logout') }}"]').on('click', function(e) {
                e.preventDefault();
                var form = document.getElementById('logout-form');
                if (form) {
                    form.submit();
                } else {
                    // Fallback: create form dynamically
                    var logoutForm = $('<form>', {
                        'method': 'POST',
                        'action': '{{ route('logout') }}',
                        'class': 'd-none'
                    });
                    logoutForm.append($('<input>', {
                        'type': 'hidden',
                        'name': '_token',
                        'value': '{{ csrf_token() }}'
                    }));
                    $('body').append(logoutForm);
                    logoutForm[0].submit();
                }
            });
        });
    </script>

</body>

</html>
