
@php
     $system = \App\Models\CompanySettings::first();
@endphp
<div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>
			<div class="sticky">
				<aside class="app-sidebar sidebar-scroll">
					<div class="main-sidebar-header active">
						<a class="desktop-logo logo-light active" href="{{url('/home')}}">
                            @if($system && $system->company_logo)
                                <img src="{{ asset('storage/uploads/images/' . $system->company_logo) }}" alt="logo" onerror="this.src='{{ asset('admin_assets/img/brand/logo.png') }}'">
                            @else
                                <img src="{{ asset('admin_assets/img/brand/logo.png') }}" alt="logo">
                            @endif
                          <!--<h2>  {{ $system->company_name }} </h2>-->
                        </a>
						<a class="desktop-logo logo-dark active" href="{{url('/home')}}"><img src="{{ asset('admin_assets/img/brand/logo-white.png') }}" class="main-logo" alt="logo"></a>
						<a class="logo-icon mobile-logo icon-light active" href="{{url('/home')}}">
                            @if($system && $system->company_logo)
                                <img src="{{ asset('storage/uploads/images/' . $system->company_logo) }}" alt="logo" onerror="this.src='{{ asset('admin_assets/img/brand/favicon.png') }}'">
                            @else
                                <img src="{{ asset('admin_assets/img/brand/favicon.png') }}" alt="logo">
                            @endif
                        </a>
						<a class="logo-icon mobile-logo icon-dark active" href="{{url('/home')}}"><img src="{{ asset('admin_assets/img/brand/favicon-white.png') }}" alt="logo"></a>
					</div>
					<div class="main-sidemenu">
						<div class="main-sidebar-loggedin">
							<div class="app-sidebar__user">
								<div class="dropdown user-pro-body text-center">
									<div class="user-pic">
										<img src="{{ asset('admin_assets/img/faces/6.jpg') }}" alt="user-img" class="rounded-circle mCS_img_loaded">
									</div>
									<div class="user-info">
										<h6 class=" mb-0 text-dark">{{ ucfirst(Auth::user()->name) }}</h6>
										<span class="text-muted app-sidebar__user-name text-sm">{{  ucfirst(Auth::user()->user_type) }}</span>
									</div>
								</div>
							</div>
						</div>
						<div class="sidebar-navs">
							<ul class="nav  nav-pills-circle">
								{{-- <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Settings" aria-describedby="tooltip365540">
									<a class="nav-link text-center m-2">
										<i class="fe fe-settings"></i>
									</a>
								</li>
								<li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Chat" aria-describedby="tooltip143427">
									<a class="nav-link text-center m-2">
										<i class="fe fe-mail"></i>
									</a>
								</li>
								<li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Followers">
									<a class="nav-link text-center m-2">
										<i class="fe fe-user"></i>
									</a>
								</li>
								<li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Logout">
									<a class="nav-link text-center m-2">
										<i class="fe fe-power"></i>
									</a>
								</li> --}}
							</ul>
						</div>
						<div class="slide-left disabled" id="slide-left"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"><path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"/></svg></div>
						<ul class="side-menu ">
							<li class="slide">
								<a class="side-menu__item" href="{{url('/home')}}"><i class="side-menu__icon fe fe-airplay"></i><span class="side-menu__label">Home</span></a>
							</li>
                            <li class="slide">
								<a class="side-menu__item" data-bs-toggle="slide"   href="javascript:void(0);"><i class="side-menu__icon fe fe-grid"></i><span class="side-menu__label">Orders</span><i class="angle fe fe-chevron-down"></i></a>
								<ul class="slide-menu">


                                    <ul class="slide-menu">
                                        <li><a class="sub-side-menu__item" href="{{ url('customer_order/list') }}">New Orders</a></li>
                                        <li><a class="sub-side-menu__item" href="{{ url('customer_order/old_list') }}">Older Orders</a></li>
                                    </ul>


							    </ul>

                            </li>

                            @if(Auth::user()->user_type='superadmin')
                            <li class="slide">
								<a class="side-menu__item" data-bs-toggle="slide"   href="javascript:void(0);"><i class="side-menu__icon fe fe-grid"></i><span class="side-menu__label">User Management</span><i class="angle fe fe-chevron-down"></i></a>
								<ul class="slide-menu">


											<li class="sub-slide2">
												<a class="sub-side-menu__item" data-bs-toggle="sub-slide2" href="javascript:void(0);">
                                                    <span class="sub-side-menu__label">Customers</span><i class="sub-angle2 fe fe-chevron-down"></i></a>
												<ul class="sub-slide-menu1">
													<li><a class="sub-slide-item2" href="{{ url('customer/create') }}">Create</a></li>
													<li><a class="sub-slide-item2" href="{{ url('customer/list') }}">List</a></li>
												</ul>
											</li>
                                            <li class="sub-slide2">
												<a class="sub-side-menu__item" data-bs-toggle="sub-slide2" href="javascript:void(0);">
                                                    <span class="sub-side-menu__label">Resellers</span><i class="sub-angle2 fe fe-chevron-down"></i></a>
												<ul class="sub-slide-menu1">
													<li><a class="sub-slide-item2" href="{{ url('reseller/create') }}">Create</a></li>
													<li><a class="sub-slide-item2" href="{{ url('reseller/list') }}">List</a></li>
												</ul>
											</li>

								</ul>

                            </li>
                            @endif
                            <li class="slide">
								<a class="side-menu__item" data-bs-toggle="slide"   href="javascript:void(0);"><i class="side-menu__icon fe fe-grid"></i><span class="side-menu__label">Artists</span><i class="angle fe fe-chevron-down"></i></a>
								<ul class="slide-menu">


                                    <ul class="slide-menu">
                                        <li><a class="sub-side-menu__item" href="{{ url('artist/create') }}">Create</a></li>
                                        <li><a class="sub-side-menu__item" href="{{ url('artist/list') }}">List</a></li>
                                    </ul>


							    </ul>

                            </li>
                            <li class="slide">
								<a class="side-menu__item" data-bs-toggle="slide"   href="javascript:void(0);"><i class="side-menu__icon fe fe-grid"></i><span class="side-menu__label">Slides</span><i class="angle fe fe-chevron-down"></i></a>
								<ul class="slide-menu">


                                    <ul class="slide-menu">
                                        <li><a class="sub-side-menu__item" href="{{ url('slide/create') }}">Create</a></li>
                                        <li><a class="sub-side-menu__item" href="{{ url('slide/list') }}">List</a></li>
                                    </ul>


							    </ul>

                            </li>
                            <li class="slide">
								<a class="side-menu__item" data-bs-toggle="slide"   href="javascript:void(0);"><i class="side-menu__icon fe fe-grid"></i><span class="side-menu__label">Request</span><i class="angle fe fe-chevron-down"></i></a>
								<ul class="slide-menu">


                                    <ul class="slide-menu">
                                        <li><a class="sub-side-menu__item" href="{{ url('slide/create') }}">Create</a></li>
                                        <li><a class="sub-side-menu__item" href="{{ url('slide/list') }}">List</a></li>
                                    </ul>


							    </ul>

                            </li>

                            <li class="slide">
								<a class="side-menu__item" data-bs-toggle="slide"   href="javascript:void(0);"><i class="side-menu__icon fe fe-grid"></i><span class="side-menu__label">Artist Field</span><i class="angle fe fe-chevron-down"></i></a>
								<ul class="slide-menu">


                                    <ul class="slide-menu">
                                        <li><a class="sub-side-menu__item" href="{{ url('artistfield/create') }}">Create</a></li>
                                        <li><a class="sub-side-menu__item" href="{{ url('artistfield/list') }}">List</a></li>
                                    </ul>


							    </ul>

                            </li>
                            <li class="slide">
								<a class="side-menu__item" data-bs-toggle="slide"   href="javascript:void(0);"><i class="side-menu__icon fe fe-grid"></i><span class="side-menu__label">Currency</span><i class="angle fe fe-chevron-down"></i></a>
								<ul class="slide-menu">


                                    <ul class="slide-menu">
                                        <li><a class="sub-side-menu__item" href="{{ url('currency/create') }}">Create</a></li>
                                        <li><a class="sub-side-menu__item" href="{{ url('currency/list') }}">List</a></li>
                                    </ul>


							    </ul>

                            </li>

							<li class="slide">
								<a class="side-menu__item" data-bs-toggle="slide"   href="javascript:void(0);"><i class="side-menu__icon fe fe-box"></i><span class="side-menu__label">Venue</span><i class="angle fe fe-chevron-down"></i></a>
								<ul class="slide-menu">
                                            <li><a class="sub-side-menu__item" href="{{ url('venue/create') }}">Create</a></li>
                                            <li><a class="sub-side-menu__item" href="{{ url('venue/list') }}">List</a></li>
                                        {{-- <ul class="sub-slide-menu1">

                                        </ul> --}}
                                        <li class="sub-slide2">
                                            <a class="sub-side-menu__item" data-bs-toggle="sub-slide2" href="javascript:void(0);">
                                                <span class="sub-side-menu__label">Venue Type</span><i class="sub-angle2 fe fe-chevron-down"></i></a>
                                            <ul class="sub-slide-menu1">
                                                <li><a class="sub-slide-item2" href="{{ url('venuetype/create') }}">Create</a></li>
                                                <li><a class="sub-slide-item2" href="{{ url('venuetype/list') }}">List</a></li>
                                            </ul>
                                        </li>
                                </li>
                                </ul>
							</li>


							<li class="slide">
								<a class="side-menu__item" data-bs-toggle="slide"   href="javascript:void(0);"><i class="side-menu__icon fe fe-package "></i><span class="side-menu__label">Events</span><i class="angle fe fe-chevron-down"></i></a>
								<ul class="slide-menu">
                                    <li><a class="sub-side-menu__item" href="{{ url('events/create') }}">Create</a></li>
                                    <li><a class="sub-side-menu__item" href="{{ url('events/list') }}">List</a></li>
                                    <li><a class="sub-side-menu__item" href="{{ route('events.requestlist') }}">Requested Event List</a></li>
                                    <li class="sub-slide2">
                                        <a class="sub-side-menu__item" data-bs-toggle="sub-slide2" href="javascript:void(0);">
                                            <span class="sub-side-menu__label">Event Type</span><i class="sub-angle2 fe fe-chevron-down"></i></a>
                                        <ul class="sub-slide-menu1">
                                            <li><a class="sub-slide-item2" href="{{ url('eventtype/create') }}">Create</a></li>
                                            <li><a class="sub-slide-item2" href="{{ url('eventtype/list') }}">List</a></li>
                                        </ul>
                                    </li>
                                    <li class="sub-slide2">
                                        <a class="sub-side-menu__item" data-bs-toggle="sub-slide2" href="javascript:void(0);">
                                            <span class="sub-side-menu__label">Event Tags</span><i class="sub-angle2 fe fe-chevron-down"></i></a>
                                        <ul class="sub-slide-menu1">
                                            <li><a class="sub-slide-item2" href="{{ url('eventtags/create') }}">Create</a></li>
                                            <li><a class="sub-slide-item2" href="{{ url('eventtags/list') }}">List</a></li>
                                        </ul>
                                    </li>
                           </li>

                        </ul>
                        <li class="slide">
                            <a class="side-menu__item" data-bs-toggle="slide"   href="javascript:void(0);"><i class="side-menu__icon fe fe-layers "></i><span class="side-menu__label">Masters</span><i class="angle fe fe-chevron-down"></i></a>
                            <ul class="slide-menu">
                                <li class="side-menu__label1"><a href="javascript:void(0);">Masters</a></li>
                                <li class="sub-slide2">
                                    <a class="sub-side-menu__item" data-bs-toggle="sub-slide2" href="javascript:void(0);">
                                        <span class="sub-side-menu__label">Location</span><i class="sub-angle2 fe fe-chevron-down"></i></a>
                                    <ul class="sub-slide-menu1">
                                        <li><a class="sub-slide-item2" href="{{ url('location/create') }}">Create</a></li>
                                        <li><a class="sub-slide-item2" href="{{ url('location/list') }}">List</a></li>
                                    </ul>
                                </li>
                                <li class="sub-slide2">
                                    <a class="sub-side-menu__item" data-bs-toggle="sub-slide2" href="javascript:void(0);">
                                        <span class="sub-side-menu__label">City</span><i class="sub-angle2 fe fe-chevron-down"></i></a>
                                    <ul class="sub-slide-menu1">
                                        <li><a class="sub-slide-item2" href="{{ url('city/create') }}">Create</a></li>
                                        <li><a class="sub-slide-item2" href="{{ url('city/list') }}">List</a></li>
                                    </ul>
                                </li>



                            </ul>
                        </li>

                        <li class="slide">
                            <a class="side-menu__item" data-bs-toggle="slide"   href="javascript:void(0);"><i class="side-menu__icon fe fe-airplay"></i><span class="side-menu__label">Tickets</span><i class="angle fe fe-chevron-down"></i></a>
                            <ul class="slide-menu">

                                <li><a class="sub-side-menu__item" href="{{ url('tickets') }}">Manage</a></li>
                                {{-- <li class="sub-slide2">
                                    <a class="sub-side-menu__item" data-bs-toggle="sub-slide2" href="javascript:void(0);">
                                        <span class="sub-side-menu__label">Ticket Type</span><i class="sub-angle2 fe fe-chevron-down"></i></a>
                                    <ul class="sub-slide-menu1">
                                        <li><a class="sub-slide-item2" href="{{ url('tickettype/create') }}">Create</a></li>
                                        <li><a class="sub-slide-item2" href="{{ url('tickettype/list') }}">List</a></li>
                                    </ul>
                                </li> --}}
                                <li class="sub-slide2">
                                    <a class="sub-side-menu__item" data-bs-toggle="sub-slide2" href="javascript:void(0);">
                                        <span class="sub-side-menu__label">Ticket Restrictions</span><i class="sub-angle2 fe fe-chevron-down"></i></a>
                                    <ul class="sub-slide-menu1">
                                        <li><a class="sub-slide-item2" href="{{ url('ticket_restrictions/create') }}">Create</a></li>
                                        <li><a class="sub-slide-item2" href="{{ url('ticket_restrictions/list') }}">List</a></li>
                                    </ul>
                                </li>
                              </li>



						</ul>

						<div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"><path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"/></svg></div>
					</div>
				</aside>
			</div>
