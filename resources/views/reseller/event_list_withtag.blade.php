<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Popular Events</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <style>
        .banner {
            background: black;
            position: relative;
            display: inline-block;
            overflow: hidden;
        }

        .banner img {
            max-height: 210px;
            object-fit: cover;
            position: relative;
            z-index: 0;
            width: auto%;
        }

        .banner::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to right, black 15%, rgba(0, 0, 0, 0.4) 30%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0.4) 70%, black 85%);
            pointer-events: none;
            z-index: 1;
        }

        .event-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
            border-radius: 12px;
            overflow: hidden;
            height: 100%;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .event-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .event-card img {
            height: 200px;
            object-fit: cover;
            width: 100%;
        }

        .event-card-body {
            padding: 1.25rem;
        }

        .event-date {
            background: linear-gradient(135deg, #d20ae9 0%, #8b00a8 100%);
            color: white;
            padding: 0.5rem;
            border-radius: 8px;
            text-align: center;
            min-width: 60px;
        }

        .event-date-day {
            font-size: 1.5rem;
            font-weight: bold;
            line-height: 1.2;
        }

        .event-date-month {
            font-size: 0.85rem;
            text-transform: uppercase;
            opacity: 0.9;
        }

        .event-time {
            font-size: 0.85rem;
            color: #6c757d;
        }

        .event-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #212529;
            margin-bottom: 0.5rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .event-location {
            font-size: 0.9rem;
            color: #6c757d;
            margin-bottom: 0.75rem;
        }

        .event-card-footer {
            background: transparent;
            border-top: 1px solid #e9ecef;
            padding: 0.75rem 1.25rem;
        }

        .btn-sell-tickets {
            background: linear-gradient(135deg, #d20ae9 0%, #8b00a8 100%);
            border: none;
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-sell-tickets:hover {
            background: linear-gradient(135deg, #8b00a8 0%, #d20ae9 100%);
            transform: scale(1.05);
            color: white;
        }

        .event-image-placeholder {
            height: 200px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
        }
    </style>

</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light mt-2">
        <div class="container">
            <a class="navbar-brand" href="{{ url('reseller/event_listing') }}"><strong class="fs-3">Just 4</strong><span class="fs-3 fw-bold"
                    style="color: #d20ae9;">
                    Entertainment</span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="sellDropdown" role="button"
                            data-bs-toggle="dropdown">Sell</a>
                        <ul class="dropdown-menu" aria-labelledby="sellDropdown">
                            <li><a class="dropdown-item" href="#">Sell Tickets</a></li>
                            <li><a class="dropdown-item" href="{{ route('reseller.mysales') }}">My Sales</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button"
                            data-bs-toggle="dropdown">Profile <i class="bi bi-person"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="profileDropdown">
                            <li><a class="dropdown-item" href="{{ route('reseller.profile') }}">My Profile</a></li>
                            <li><a class="dropdown-item" href="#">Settings</a></li>
                            <li><a class="dropdown-item" href="#">Log Out</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Image Section -->
    <div class="container-fluid p-0 banner">
        @if (!empty($events->first()->event_image))
            <img src="https://images.unsplash.com/photo-1567351344506-b2e8a94e273b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                class="img-fluid d-block mx-auto w-100">
        @else
            <img src="https://images.unsplash.com/photo-1567351344506-b2e8a94e273b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                class="img-fluid d-block mx-auto w-100">
        @endif
    </div>




    <!-- Hero Section -->
    <div class="container mt-4">
        <div class="mt-4">
            <h1 class="fw-bold">
                {{ !empty($events->first()->artist_names) ? implode(', ', $events->first()->artist_names) : 'Unknown Artist' }}
            </h1>
            <p class="text-muted fs-4">Sell tickets | <span class="">{{ $events->count() }} upcoming events</span>
            </p>
        </div>

        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link fw-bold" href="#">Tickets</a>
            </li>
        </ul>

        <!-- Events Listing -->
        <div class="mt-4">
            <p class="text-muted fw-bold mb-4">{{ $events->count() }} events in all locations</p>

            <div class="row g-4">
                @foreach ($events as $val)
                    @php
                        $eventEnded = !empty($val->event_to_date)
                            ? \Carbon\Carbon::parse($val->event_to_date)->endOfDay()->isPast()
                            : false;
                    @endphp
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="card event-card h-100">
                            @if (!empty($val->event_image))
                                <img src="{{ asset('storage/uploads/event/' . $val->event_image) }}" 
                                     class="card-img-top" 
                                     alt="{{ $val->event_name }}"
                                     onerror="this.src='https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?q=80&w=2070&auto=format&fit=crop'">
                            @else
                                <div class="event-image-placeholder">
                                    <i class="bi bi-calendar-event"></i>
                                </div>
                            @endif
                            
                            <div class="card-body event-card-body">
                                <div class="d-flex align-items-start mb-3">
                                    <div class="event-date me-3">
                                        <div class="event-date-day">{{ date('d', strtotime($val->event_from_date)) }}</div>
                                        <div class="event-date-month">{{ date('M', strtotime($val->event_from_date)) }}</div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="event-time">
                                            <i class="bi bi-calendar3"></i> {{ date('D', strtotime($val->event_from_date)) }}
                                        </div>
                                        <div class="event-time">
                                            <i class="bi bi-clock"></i> {{ date('H:i', strtotime($val->event_from_time)) }}
                                        </div>
                                    </div>
                                    @if ($eventEnded)
                                        <span class="badge bg-secondary ms-2">Event Ended</span>
                                    @endif
                                </div>
                                
                                <h5 class="event-title">{{ $val->event_name }}</h5>
                                
                                <p class="event-location mb-0">
                                    <i class="bi bi-geo-alt"></i> 
                                    @if($val->venue_name)
                                        {{ $val->venue_name }}, 
                                    @endif
                                    @if($val->city_name)
                                        {{ $val->city_name }}, 
                                    @endif
                                    @if($val->country_name)
                                        {{ $val->country_name }}
                                    @endif
                                </p>
                            </div>
                            
                            <div class="card-footer event-card-footer">
                                <a href="{{ $eventEnded ? 'javascript:void(0);' : route('reseller.selltickets', ['id' => $val->id]) }}" 
                                   class="btn btn-sell-tickets w-100 {{ $eventEnded ? 'disabled' : '' }}"
                                   aria-disabled="{{ $eventEnded ? 'true' : 'false' }}">
                                    <i class="bi bi-ticket-perforated"></i> Sell Tickets
                                </a>
                            </div>
                        </div>
                        </div>
                @endforeach
            </div>
            
            @if($events->count() == 0)
                <div class="text-center py-5">
                    <i class="bi bi-inbox" style="font-size: 4rem; color: #dee2e6;"></i>
                    <p class="text-muted mt-3">No events found</p>
                </div>
            @endif
        </div>

    </div>

    <!-- Footer -->
    <footer class="bg-light py-5 mt-5">
        <div class="container">
            <div class="row text-center text-md-start">
                <!-- Guarantee Section -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <h5 class="fw-bold"><i class="bi bi-shield-check text-success"></i> Just 4 <span
                            style="color: #d20ae9;">Entertainment</span> <span class="text-muted">Guarantee</span>
                    </h5>
                    <ul class="list-unstyled text-muted">
                        <li><i class="bi bi-check-circle text-success"></i> World-class security checks</li>
                        <li><i class="bi bi-check-circle text-success"></i> Transparent pricing</li>
                        <li><i class="bi bi-check-circle text-success"></i> 100% order guarantee</li>
                        <li><i class="bi bi-check-circle text-success"></i> Customer service from start to finish</li>
                    </ul>
                </div>

                <!-- Our Company Section -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5 class="fw-bold">Our Company</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-muted text-decoration-none">About Us</a></li>
                        <li><a href="#" class="text-muted text-decoration-none">Partners</a></li>
                        <li><a href="#" class="text-muted text-decoration-none">Affiliate Program</a></li>
                        <li><a href="#" class="text-muted text-decoration-none">Corporate Service</a></li>
                        <li><a href="#" class="text-muted text-decoration-none">Careers</a></li>
                    </ul>
                </div>

                <!-- Help Section -->
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5 class="fw-bold">Have Questions?</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-muted text-decoration-none">Help Center / Contact Us</a>
                        </li>
                    </ul>
                </div>

                <!-- Live Events Section -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5 class="fw-bold">Live events all over the world</h5>
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-secondary"><i class="bi bi-geo-alt"></i> India</button>
                        <div class="border p-2">
                            <p class="mb-0"><i class="bi bi-translate"></i> English (UK)</p>
                            <hr class="my-1">
                            <p class="mb-0">INR Indian Rupee</p>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <!-- Copyright and Legal Links -->
            <div class="text-center text-muted">
                <p class="mb-1">&copy; Just 4 Entertainment 2025 <a href="#"
                        class="text-decoration-none fw-bold">Company Details</a></p>
                <p class="small">
                    Use of this website constitutes acceptance of the
                    <a href="#" class="text-decoration-none">Terms and Conditions</a>,
                    <a href="#" class="text-decoration-none">Privacy Policy</a>, and
                    <a href="#" class="text-decoration-none">Cookies Policy</a>.
                    <br>
                    <a href="#" class="text-decoration-none">Mobile Privacy Policy</a> |
                    <a href="#" class="text-decoration-none">Do Not Share My Personal Information</a> /
                    <a href="#" class="text-decoration-none">Your Privacy Choices</a>
                </p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
