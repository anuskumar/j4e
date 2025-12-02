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
    <link rel="icon" href="{{ asset('admin_assets/img/brand/favicon.png') }}" type="image/x-icon" />

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
                        <a href="index.html" class="header-logo"><img
                                src="{{ asset('admin_assets/img/brand/logo.png') }}" class="logo-11"></a>
                        <a href="index.html" class="header-logo">
                            @if($system && $system->company_logo)
                                <img src="{{ asset('storage/uploads/images/' . $system->company_logo) }}" alt="logo" onerror="this.src='{{ asset('admin_assets/img/brand/logo.png') }}'">
                            @else
                                <img src="{{ asset('admin_assets/img/brand/logo.png') }}" alt="logo">
                            @endif
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
                                @php
                                    use App\Models\RequestEventModel;
                                    $data = RequestEventModel::where('markas_read', 0)->get();
                                    $data_count = RequestEventModel::where('markas_read', 0)->count();
                                @endphp
                                <div class="dropdown nav-item main-header-notification">
                                    <a class="new nav-link" href="javascript:void(0);"><i
                                            class="fe fe-bell"></i><span class=" pulse"></span></a>
                                    <div class="dropdown-menu">
                                        <div class="menu-header-content bg-primary-gradient text-start d-flex">
                                            <div class="">
                                                <h6 class="menu-header-title text-white mb-0">{{ $data_count }} new
                                                    Notifications</h6>
                                            </div>
                                            {{-- <div class="my-auto ms-auto">
													<a class="badge bg-pill bg-warning float-end"   href="javascript:void(0);">Mark All Read</a>
												</div> --}}
                                        </div>
                                        <div class="main-notification-list Notification-scroll">
                                            @foreach ($data as $val)
                                                <a class="d-flex p-3 border-bottom"
                                                    href="{{ route('events.requestlist') }}">
                                                    <div class="notifyimg bg-success-transparent">
                                                        <i class="la la-shopping-basket text-success"></i>
                                                    </div>
                                                    <div class="ms-3">
                                                        <h5 class="notification-label mb-1">{{ $val->name }} added
                                                            new event</h5>
                                                        <div class="notification-subtext">
                                                            {{ \Carbon\Carbon::parse($val->created_at)->diffForHumans() }}
                                                        </div>
                                                    </div>
                                                    <div class="ms-auto">
                                                        <i class="las la-angle-right text-end text-muted"></i>
                                                    </div>
                                                </a>
                                            @endforeach

                                            {{-- <a class="d-flex p-3 border-bottom"   href="javascript:void(0);">
													<div class="notifyimg bg-danger-transparent">
														<i class="la la-user-check text-danger"></i>
													</div>
													<div class="ms-3">
														<h5 class="notification-label mb-1">22 verified registrations</h5>
														<div class="notification-subtext">2 hour ago</div>
													</div>
													<div class="ms-auto" >
														<i class="las la-angle-right text-end text-muted"></i>
													</div>
												</a>
												<a class="d-flex p-3 border-bottom"   href="javascript:void(0);">
													<div class="notifyimg bg-primary-transparent">
														<i class="la la-check-circle text-primary"></i>
													</div>
													<div class="ms-3">
														<h5 class="notification-label mb-1">Project has been approved</h5>
														<div class="notification-subtext">4 hour ago</div>
													</div>
													<div class="ms-auto" >
														<i class="las la-angle-right text-end text-muted"></i>
													</div>
												</a>
												<a class="d-flex p-3 border-bottom"   href="javascript:void(0);">
													<div class="notifyimg bg-pink-transparent">
														<i class="la la-file-alt text-pink"></i>
													</div>
													<div class="ms-3">
														<h5 class="notification-label mb-1">New files available</h5>
														<div class="notification-subtext">10 hour ago</div>
													</div>
													<div class="ms-auto" >
														<i class="las la-angle-right text-end text-muted"></i>
													</div>
												</a>
												<a class="d-flex p-3 border-bottom"   href="javascript:void(0);">
													<div class="notifyimg bg-warning-transparent">
														<i class="la la-envelope-open text-warning"></i>
													</div>
													<div class="ms-3">
														<h5 class="notification-label mb-1">New review received</h5>
														<div class="notification-subtext">1 day ago</div>
													</div>
													<div class="ms-auto" >
														<i class="las la-angle-right text-end text-muted"></i>
													</div>
												</a>
												<a class="d-flex p-3"   href="javascript:void(0);">
													<div class="notifyimg bg-purple-transparent">
														<i class="la la-gem text-purple"></i>
													</div>
													<div class="ms-3">
														<h5 class="notification-label mb-1">Updates Available</h5>
														<div class="notification-subtext">2 days ago</div>
													</div>
													<div class="ms-auto" >
														<i class="las la-angle-right text-end text-muted"></i>
													</div>
												</a> --}}
                                        </div>
                                        <div class="dropdown-footer">
                                            <a href="{{ route('events.requestlist') }}">VIEW ALL</a>
                                        </div>
                                    </div>
                                </div>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    class="d-none">
                                    @csrf
                                </form>
                                <div class="dropdown main-profile-menu nav nav-item nav-link">
                                    <a class="profile-user d-flex" href=""><img
                                            src="{{ asset('admin_assets/img/faces/6.jpg') }}" alt="user-img"
                                            class="rounded-circle mCS_img_loaded"><span></span></a>

                                    <div class="dropdown-menu">
                                        <div class="main-header-profile header-img">
                                            <div class="main-img-user"><img alt=""
                                                    src="{{ asset('admin_assets/img/faces/6.jpg') }}"></div>
                                            <h6>{{ ucfirst(Auth::user()->name) }} {{ Auth::user()->id }}</h6>
                                            <span>{{ ucfirst(Auth::user()->user_type) }}</span>
                                        </div>
                                        <a class="dropdown-item" href="{{ route('reseller.profile') }}"><i
                                                class="far fa-user"></i> My Profile</a>
                                        {{-- <a class="dropdown-item" href="profile.html"><i class="far fa-edit"></i> Edit Profile</a> --}}
                                        {{-- <a class="dropdown-item" href="profile.html"><i class="far fa-clock"></i> Activity Logs</a> --}}
                                        <a class="dropdown-item" href="profile.html"><i class="fas fa-sliders-h"></i>
                                            Account Settings</a>
                                        @if (Auth::user()->user_type == 'superadmin')
                                            <a class="dropdown-item" href="{{ url('admin/company_settings') }}"><i
                                                    class="fas fa-sliders-h"></i> Company Settings</a>
                                        @endif

                                        <a class="dropdown-item" href="#"
                                            onclick="event.preventDefault();
                                              document.getElementById('logout-form').submit();"><i
                                                class="fas fa-sign-out-alt"></i>Logout </a>
                                    </div>
                                </div>
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
                        <h4 class="content-title mb-2">Hi, welcome back!</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('home') }}">Dashboard</a></li>
                                {{-- <li class="breadcrumb-item active" aria-current="page">Project</li> --}}
                            </ol>
                        </nav>
                    </div>
                    <div class="d-flex my-auto">
                        <div class=" d-flex right-page">
                            {{-- <div class="d-flex justify-content-center me-5">
									<div class="">
										<span class="d-block">
											<span class="label ">EXPENSES</span>
										</span>
										<span class="value">
											$53,000
										</span>
									</div>
									<div class="ms-3 mt-2">
										<span class="sparkline_bar"></span>
									</div>
								</div> --}}
                            {{-- <div class="d-flex justify-content-center">
									<div class="">
										<span class="d-block">
											<span class="label">PROFIT</span>
										</span>
										<span class="value">
											$34,000
										</span>
									</div>
									<div class="ms-3 mt-2">
										<span class="sparkline_bar31"></span>
									</div>
								</div> --}}
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

    <div class="loader" id="loader">
    </div>
    <!-- page closed -->

    <!--- Back-to-top --->
    <a href="#top" id="back-to-top"><i class="las la-angle-double-up"></i></a>
    <!--- JQuery min js --->
    <script src="{{ asset('admin_assets/js/summernote.min.js') }}"></script>
    <script src="{{ asset('admin_assets/plugins/jquery/jquery.min.js') }}"></script>



    <!--- Datepicker js --->
    <script src="{{ asset('admin_assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>

    <!--- Bootstrap Bundle js --->
    <script src="{{ asset('admin_assets/plugins/bootstrap/popper.min.js') }}"></script>
    <script src="{{ asset('admin_assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>

    <!--- Ionicons js --->
    <script src="{{ asset('admin_assets/plugins/ionicons/ionicons.js') }}"></script>

    <!--- Chart bundle min js --->
    <script src="{{ asset('admin_assets/plugins/chart.js/Chart.bundle.min.js') }}"></script>

    <!--- JQuery sparkline js --->
    <script src="{{ asset('admin_assets/plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script>

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

    <!--- sticky js --->
    <script src="{{ asset('admin_assets/js/sticky.js') }}"></script>

    <!-- right-sidebar js -->
    <script src="{{ asset('admin_assets/plugins/sidebar/sidebar.js') }}"></script>
    <script src="{{ asset('admin_assets/plugins/sidebar/sidebar-custom.js') }}"></script>

    <!-- Morris js -->
    <script src="{{ asset('admin_assets/plugins/raphael/raphael.min.js') }}"></script>
    <script src="{{ asset('admin_assets/plugins/morris.js/morris.min.js') }}"></script>

    <!--- Scripts js --->
    <script src="{{ asset('admin_assets/js/script.js') }}"></script>

    <!--- Index js --->
    <script src="{{ asset('admin_assets/js/index.js') }}"></script>

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

</body>

</html>
