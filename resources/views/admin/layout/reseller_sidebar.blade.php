
@php
     $system = \App\Models\CompanySettings::first();
@endphp
<div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>
			<div class="sticky">
				<aside class="app-sidebar sidebar-scroll">
					<div class="main-sidebar-header active">
						<a class="desktop-logo logo-light active" href="{{url('/home')}}">
                            <img src="{{ $appLogoUrl }}" class="main-logo" alt="logo">
                        </a>
						<a class="desktop-logo logo-dark active" href="{{url('/home')}}"><img src="{{ $appLogoUrl }}" class="main-logo" alt="logo"></a>
						<a class="logo-icon mobile-logo icon-light active" href="{{url('/home')}}"><img src="{{ $appLogoUrl }}" alt="logo"></a>
						<a class="logo-icon mobile-logo icon-dark active" href="{{url('/home')}}"><img src="{{ $appLogoUrl }}" alt="logo"></a>
					</div>
					<div class="main-sidemenu">
						<div class="main-sidebar-loggedin">
							<div class="app-sidebar__user">
								<div class="dropdown user-pro-body text-center">
									<div class="user-pic">
										<img src="{{ Auth::user()->profileImageUrl() }}" alt="user-img" class="rounded-circle mCS_img_loaded"
                                            onerror="this.src='{{ asset('admin_assets/img/faces/6.jpg') }}'">
									</div>
									<div class="user-info">
										<h6 class=" mb-0 text-dark">{{ ucfirst(Auth::user()->name) }}</h6>
										<span class="text-muted app-sidebar__user-name text-sm">{{  ucfirst(Auth::user()->user_type) }}</span>
									</div>
								</div>
							</div>
						</div>
						
						<div class="slide-left disabled" id="slide-left"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"><path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"/></svg></div>
						<ul class="side-menu ">
							<li class="slide">
								<a class="side-menu__item" href="{{url('/')}}"><i class="side-menu__icon fe fe-airplay"></i><span class="side-menu__label">Home</span></a>
							</li>


                            <li class="slide">
								<a class="side-menu__item" data-bs-toggle="slide"   href="{{ url('reseller/event_listing') }}"><i class="side-menu__icon fe fe-grid"></i><span class="side-menu__label">Sell Tickets</span><i class=" "></i></a>
								{{-- <ul class="slide-menu">


                                    <ul class="slide-menu">
                                        <li><a class="sub-side-menu__item" href="{{ url('reseller/event_listing') }}">Add Tickets</a></li>
                                        <li><a class="sub-side-menu__item" href="{{ url('tickets') }}">My Tickets</a></li>
                                    </ul>


							    </ul> --}}

                            </li>
                            <li class="slide">
								<a class="side-menu__item" data-bs-toggle="slide"   href="{{ route('reseller.mylistings') }}"><i class="side-menu__icon fe fe-grid"></i><span class="side-menu__label">My Listing</span><i class=" "></i></a>
                            </li>
                            <li class="slide">
								<a class="side-menu__item" data-bs-toggle="slide"   href="{{ route('reseller.mysales') }}"><i class="side-menu__icon fe fe-grid"></i><span class="side-menu__label">My Sales</span><i class=" "></i></a>
                            </li>
                            {{-- <li class="slide">
								<a class="side-menu__item" data-bs-toggle="slide"   href="javascript:void(0);"><i class="side-menu__icon fe fe-grid"></i><span class="side-menu__label">My Tickets</span><i class="angle fe fe-chevron-down"></i></a>
								<ul class="slide-menu">


                                    <ul class="slide-menu">
                                        <li><a class="sub-side-menu__item" href="{{ url('tickets') }}">My Tickets</a></li>
                                        <li><a class="sub-side-menu__item" href="{{ url('artist/list') }}">Orders</a></li>
                                        <li><a class="sub-side-menu__item" href="{{ url('artist/list') }}">Listing</a></li>
                                        <li><a class="sub-side-menu__item" href="{{ url('artist/list') }}">Payments</a></li>
                                    </ul>


							    </ul>

                            </li> --}}
                            {{-- <li class="slide">
								<a class="side-menu__item" data-bs-toggle="slide"   href="javascript:void(0);"><i class="side-menu__icon fe fe-grid"></i><span class="side-menu__label">Orders</span><i class="angle fe fe-chevron-down"></i></a>
								<ul class="slide-menu">


                                    <ul class="slide-menu">
                                        <li><a class="sub-side-menu__item" href="{{ url('customer_order/list') }}">New Orders</a></li>
                                        <li><a class="sub-side-menu__item" href="{{ url('customer_order/old_list') }}">Older Orders</a></li>
                                    </ul>


							    </ul>

                            </li> --}}
                            <li class="slide">
								<a class="side-menu__item" data-bs-toggle="slide"   href="{{ url('reseller/profile') }}"><i class="side-menu__icon fe fe-grid"></i><span class="side-menu__label">Settings</span><i class=" "></i></a>
								<ul class="slide-menu">


                                    {{-- <ul class="slide-menu">
                                        <li><a class="sub-side-menu__item" href="{{ url('reseller/profile') }}">Account Settings</a></li> --}}
                                        {{-- <li><a class="sub-side-menu__item" href="{{ url('artist/list') }}">Verify Email</a></li>
                                        <li><a class="sub-side-menu__item" href="{{ url('artist/list') }}">Verify PhoneNumber</a></li> --}}

                                    {{-- </ul> --}}


							    </ul>

                            </li>

						<div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"><path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"/></svg></div>
					</div>
				</aside>
			</div>
