<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sell Events Tickets</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.css">
    <style>
        :root {
            --primary-color: #d20ae9;
            --primary-dark: #8b00a8;
            --success-color: #28a745;
            --danger-color: #dc3545;
            --border-radius: 12px;
            --box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --box-shadow-hover: 0 8px 15px rgba(0, 0, 0, 0.15);
        }

        body {
            background-color: #f8f9fa;
        }

        .form-section-card {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
            background: white;
        }

        .form-section-card:hover {
            box-shadow: var(--box-shadow-hover);
        }

        .form-section-header {
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 1rem;
            margin-bottom: 1.5rem;
        }

        .form-section-header h5,
        .form-section-header h6 {
            color: #212529;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-section-header .icon {
            color: var(--primary-color);
            font-size: 1.5rem;
        }

        .btn-ticket {
            flex: 1;
            min-width: 60px;
            max-width: 80px;
            padding: 12px 16px;
            font-size: 16px;
            font-weight: 600;
            background-color: #f8f9fa;
            border: 2px solid #dee2e6;
            border-radius: 8px;
            color: #495057;
            transition: all 0.3s ease;
        }

        .btn-ticket:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }

        .btn-ticket.active {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            border-color: var(--primary-color);
            color: white;
            box-shadow: 0 4px 12px rgba(210, 10, 233, 0.3);
        }

        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
        }

        .form-control,
        .form-select {
            border-radius: 8px;
            border: 2px solid #dee2e6;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(210, 10, 233, 0.25);
        }

        .ticket-type {
            border: 2px solid #dee2e6;
            border-radius: var(--border-radius);
            cursor: pointer;
            transition: all 0.3s ease;
            min-height: 120px;
        }

        .ticket-type:hover {
            border-color: var(--primary-color);
            transform: translateY(-3px);
            box-shadow: var(--box-shadow-hover);
        }

        .ticket-type.border-primary {
            border: 3px solid var(--primary-color) !important;
            box-shadow: 0 0 0 0.2rem rgba(210, 10, 233, 0.25);
        }

        .form-check-input {
            width: 1.25rem;
            height: 1.25rem;
            border: 2px solid #dee2e6;
            cursor: pointer;
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .form-check-label {
            margin-left: 0.5rem;
            cursor: pointer;
            color: #495057;
        }

        .btn-submit {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            border: none;
            border-radius: var(--border-radius);
            padding: 1rem 3rem;
            font-size: 1.1rem;
            font-weight: 600;
            color: white;
            box-shadow: 0 4px 15px rgba(210, 10, 233, 0.3);
            transition: all 0.3s ease;
            min-width: 200px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(210, 10, 233, 0.4);
            color: white;
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .info-alert {
            border-left: 4px solid var(--primary-color);
            border-radius: var(--border-radius);
            background: linear-gradient(135deg, rgba(210, 10, 233, 0.05) 0%, rgba(139, 0, 168, 0.05) 100%);
        }

        .success-alert {
            border-left: 4px solid var(--success-color);
            border-radius: var(--border-radius);
        }

        .input-group-text {
            background-color: #f8f9fa;
            border: 2px solid #dee2e6;
            border-right: none;
            border-radius: 8px 0 0 8px;
            font-weight: 600;
            color: var(--primary-color);
        }

        .input-group .form-control {
            border-left: none;
            border-radius: 0 8px 8px 0;
        }

        .input-group .form-control:focus {
            border-left: 2px solid var(--primary-color);
        }

        .converted-value-display {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 1rem;
            border-radius: 8px;
            border: 2px solid #dee2e6;
        }

        .converted-value-display label {
            font-size: 0.875rem;
            color: #6c757d;
            margin-bottom: 0.25rem;
        }

        .converted-value-display #converted-value {
            font-size: 1.5rem;
            color: var(--primary-color);
        }

        .section-divider {
            height: 2px;
            background: linear-gradient(90deg, transparent, #dee2e6, transparent);
            margin: 2rem 0;
        }

        .required-field::after {
            content: " *";
            color: var(--danger-color);
        }

        .error-message {
            color: var(--danger-color);
            font-size: 0.875rem;
            margin-top: 0.25rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        @media (max-width: 768px) {
            .btn-submit {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light mt-2">
        <div class="container">
            <a class="navbar-brand" href="{{ url('reseller/event_listing') }}"><strong class="fs-3">Just
                    4</strong><span class="fs-3 fw-bold" style="color: #d20ae9;">
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

    <!-- Main Content -->
    <div class="container mt-4">
        <div class="card mb-3" style="width: 100%;">
            <div class="row g-0">
                <div class="col-md-2 d-none d-md-block">
                    <img src="https://images.unsplash.com/photo-1567351344506-b2e8a94e273b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                        class="img-fluid rounded-start" alt="The Eagles Concert"
                        style="height:auto; width: 100%; object-fit: cover;">
                </div>
                <div class="col-md-10 col-12 d-flex align-items-center">
                    <div class="card-body p-4">
                        <h6 class="card-title fw-bold">{{ $event->event_name ?? 'Event Name' }}</h6>
                        <p class="card-text text-muted mb-0">{{ $data->venue_name ?? 'Venue Name' }},
                            {{ $data->city_name ?? 'City Name' }}, {{ $data->country_name ?? 'Country Name' }}</p>
                        <p class="card-text mb-0"><small class="text-body-secondary fw-bold">
                                {{ date('d M', strtotime($event->event_from_date)) }}
                                &bull;
                                {{ date('D', strtotime($event->event_from_date)) }} &bull;
                                {{ $event_timing ? date('H:i', strtotime($event_timing->from_time)) : 'Time is Not available' }}</small> 
                        </p>
                        <p class="mb-0">
                            <span
                                style="background: lightblue; padding: 2px 6px; font-size: 12px; border-radius: 4px; border: 1px solid #0b75df;">
                                @if (\Carbon\Carbon::parse($event->event_to_date)->isPast())
                                    Event Ended <i class="bi bi-exclamation-circle-fill text-danger"></i>
                                @elseif (\Carbon\Carbon::now()->diffInDays($event->event_from_date) <= 7)
                                    This week <i class="bi bi-exclamation-circle-fill text-warning"></i>
                                @elseif (
                                    \Carbon\Carbon::now()->diffInDays($event->event_from_date) > 7 &&
                                        \Carbon\Carbon::now()->diffInDays($event->event_from_date) <= 14)
                                    Next week <i class="bi bi-exclamation-circle-fill text-success"></i>
                                @else
                                    Event in the coming weeks <i class="bi bi-exclamation-circle-fill text-info"></i>
                                @endif
                            </span>
                        </p>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-4">
        <!-- Display validation errors -->
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Please fix the following errors:</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form method="POST" action="{{ route('reseller.sellticketsave', ['id' => $id]) }}"
            enctype="multipart/form-data" id="ticketForm">
            @csrf
            <!-- Enter Number of Tickets -->
            <div class="card form-section-card p-4">
                <div class="form-section-header">
                    <h6><i class="bi bi-ticket-perforated icon"></i> Select Number of Tickets <span class="text-danger">*</span></h6>
                </div>
                <p class="text-muted mb-4">
                    <i class="bi bi-info-circle"></i> If seat numbers are specified on your tickets, all tickets must be consecutive.
                    For non-consecutive tickets, you must create separate listings.
                </p>
                <div class="d-flex gap-2 flex-wrap mb-3">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                    <button type="button" class="btn btn-ticket ticket-btn"
                        data-value="<?= $i ?>"><?= $i ?></button>
                    <?php endfor; ?>
                    <button type="button" class="btn btn-ticket" id="showDropdown">6+</button>
                </div>

                <!-- Hidden input to store the selected value -->
                <input type="hidden" id="ticketInput" name="ticket_count" value="">
                @error('ticket_count')
                    <div class="error-message">
                        <i class="bi bi-exclamation-circle"></i> {{ $message }}
                    </div>
                @enderror

                <div id="ticketDropdownContainer" class="mt-3 d-none">
                    <label for="ticketQuantity" class="form-label">Select Quantity</label>
                    <select id="ticketQuantity" class="form-select">
                        <option selected value="">Select Tickets</option>
                        <?php for ($i = 6; $i <= 30; $i++): ?>
                        <option value="<?= $i ?>"><?= $i ?> Tickets</option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>


            <!-- Enter Seating Details -->
            <div class="card form-section-card p-4">
                <div class="form-section-header">
                    <h5><i class="bi bi-geo-alt icon"></i> Enter Seating Details <span class="text-danger fs-6">*</span></h5>
                </div>
                <p class="text-muted mb-4">
                    <i class="bi bi-info-circle"></i> You are required to provide section, row, and seat information if
                    available. Listings can be updated using My Account.
                </p>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label required-field" for="venue_seating">Section</label>
                        <select class="form-select" name="venue_seating" id="venue_seating">
                            <option value="">Please select...</option>
                            @foreach ($venue_seatings as $seating)
                                <option value="{{ $seating->id }}" {{ old('venue_seating') == $seating->id ? 'selected' : '' }}>
                                    {{ $seating->seating_type_name ?? 'Unnamed Section' }}
                                </option>
                            @endforeach
                        </select>
                        @error('venue_seating')
                            <div class="error-message">
                                <i class="bi bi-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label required-field">Row (Enter a single letter A-Z)</label>
                        <input type="text" class="form-control" name="row" placeholder="e.g., A, B, C"
                            value="{{ old('row') }}" maxlength="1" style="text-transform: uppercase;">
                        @error('row')
                            <div class="error-message">
                                <i class="bi bi-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label required-field">Seat Number (0 - 99)</label>
                    <div class="d-flex gap-3 align-items-end">
                        <div class="flex-grow-1">
                            <input type="text" class="form-control" name="seat_from" value="{{ old('seat_from') }}"
                                placeholder="Seat From" maxlength="2">
                        </div>
                        <span class="fw-bold text-muted mb-2">to</span>
                        <div class="flex-grow-1">
                            <input type="text" class="form-control" name="seat_to" 
                                placeholder="Auto-filled" value="{{ old('seat_to') }}" maxlength="2" readonly>
                            <small class="text-muted">Auto-calculated</small>
                        </div>
                    </div>
                    @error('seat_to')
                        <div class="error-message mt-2">
                            <i class="bi bi-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label">If you are unable to provide seating information, please select a reason:</label>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="seat_reason" id="reason1"
                            value="not_provided" {{ old('seat_reason') == 'not_provided' ? 'checked' : '' }}>
                        <label class="form-check-label" for="reason1">
                            The primary site has not provided me with this information
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="seat_reason" id="reason2"
                            value="other" {{ old('seat_reason') == 'other' ? 'checked' : '' }}>
                        <label class="form-check-label" for="reason2">Other</label>
                    </div>
                </div>

                <div class="section-divider"></div>

                <!-- selecting ticket Details -->
                <div class="mb-0">
                    <label class="form-label fw-bold mb-3">Do you want to sell all your tickets together?</label>
                    @foreach ($splittypes as $split)
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="sell_together"
                                id="sell_{{ $split->id }}" value="{{ $split->id }}" {{ old('sell_together') == $split->id ? 'checked' : '' }}>
                            <label class="form-check-label" for="sell_{{ $split->id }}">
                                {{ $split->split_name }}
                            </label>
                        </div>
                    @endforeach
                    @error('sell_together')
                        <div class="error-message mt-2">
                            <i class="bi bi-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="alert alert-success success-alert d-flex align-items-center mb-4" role="alert">
                <i class="bi bi-check-circle me-2 fs-5"></i>
                <span>Unlike other sites, it is always free to list your tickets for sale on Just 4 Entertainment</span>
            </div>

            <!-- Enter Face Value Section -->
            <div class="card form-section-card p-4">
                <div class="form-section-header">
                    <h6><i class="bi bi-currency-dollar icon"></i> Enter Face Value</h6>
                </div>
                <div class="alert alert-light info-alert d-flex align-items-center mb-4" role="alert">
                    <i class="bi bi-info-circle me-2"></i>
                    <span>Face value is the price printed on the ticket, excluding any booking fees.</span>
                </div>

                <div class="row g-3">
                    {{-- Currency Dropdown --}}
                    <div class="col-md-4">
                        <label for="currency" class="form-label required-field">Currency</label>
                        <select class="form-select" id="currency" name="currency">
                            <option value="">Select Currency</option>
                            @foreach ($currency as $val)
                                <option value="{{ $val->id }}" data-code="{{ $val->short_name }}" {{ old('currency') == $val->id ? 'selected' : '' }}>
                                    {{ $val->symbol . ' ' . $val->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('currency')
                            <div class="error-message">
                                <i class="bi bi-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Amount Input --}}
                    <div class="col-md-3">
                        <label for="amount" class="form-label required-field">Amount (Price per ticket)</label>
                        <div class="input-group">
                            <span class="input-group-text" id="currency-code">💱</span>
                            <input type="number" step="0.01" class="form-control" id="amount" name="amount"
                                placeholder="0.00" value="{{ old('amount') }}">
                        </div>
                        @error('amount')
                            <div class="error-message">
                                <i class="bi bi-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Cents Input --}}
                    <div class="col-md-2">
                        <label for="cents" class="form-label">Cents</label>
                        <input type="number" class="form-control" id="cents" name="cents"
                            placeholder="00" maxlength="2" min="0" max="99" value="{{ old('cents') }}">
                    </div>

                    {{-- Converted Value Display --}}
                    <div class="col-md-3">
                        <div class="converted-value-display">
                            <label>Converted Value</label>
                            <div id="converted-value" class="fw-bold">$0.00 USD</div>
                        </div>
                    </div>
                </div>
            </div>



            <!-- Ticket type Section -->
            <div class="card form-section-card p-4">
                <div class="form-section-header">
                    <h5><i class="bi bi-ticket-perforated icon"></i> Choose Ticket Type <span class="text-danger">*</span></h5>
                </div>
                <div class="row g-3">
                    <input type="hidden" id="ticketTypeInput" name="ticket_type" value="{{ old('ticket_type') }}">
                    @foreach ($ticket_type as $type)
                        <div class="col-md-6">
                            <div class="card ticket-type p-4"
                                style="background-color: {{ $type->background_color ?? ($loop->iteration % 2 == 0 ? '#e3f2fd' : '#f1f8e9') }};"
                                onclick="selectTicketType('{{ $type->id }}', '{{ $type->ticket_type_name }}')">
                                <h6 class="fw-bold mb-2">{{ $type->ticket_type_name }}</h6>
                                <p class="text-muted mb-0 small">{{ $type->description ?? 'Select this ticket type' }}</p>
                            </div>

                            <!-- Mobile App dropdown section within the same column -->
                            @if (strtolower($type->ticket_type_name) == 'mobile ticket transfer' ||
                                    (strpos(strtolower($type->ticket_type_name), 'mobile') !== false &&
                                        strpos(strtolower($type->ticket_type_name), 'transfer') !== false))
                                <div id="mobileAppSelect-{{ $type->id }}"
                                    class="mt-3 d-none mobile-app-select">
                                    <input type="hidden" id="mobileAppInput" name="mobile_app" value="{{ old('mobile_app') }}">
                                    <label for="mobileApp" class="form-label required-field">Mobile Application</label>
                                    <select id="mobileApp" class="form-select">
                                        <option value="">Select an application</option>
                                        @foreach ($mobile_applications as $app)
                                            <option value="{{ $app->id }}" {{ old('mobile_app') == $app->id ? 'selected' : '' }}>{{ $app->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('mobile_app')
                                        <div class="error-message">
                                            <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
                @error('ticket_type')
                    <div class="error-message mt-3">
                        <i class="bi bi-exclamation-circle"></i> {{ $message }}
                    </div>
                @enderror
            </div>
            
            <div class="alert alert-success success-alert d-flex align-items-center mt-4" role="alert">
                <i class="bi bi-ticket me-2 fs-5"></i>
                <span>99 buyers are currently searching for tickets for this event. Now is a good time to sell!</span>
            </div>

            <!-- Restriction and requirements Section -->
            <div class="card form-section-card p-4">
                <div class="form-section-header">
                    <h5><i class="bi bi-shield-exclamation icon"></i> Select Restrictions on Use</h5>
                </div>
                <p class="text-muted mb-4">If any of the following conditions apply to your tickets, please select them from the list below.</p>
                <div class="row g-3">
                    @foreach ($restrictions as $restriction)
                        <div class="col-md-4">
                            <div class="form-check">
                                <input type="checkbox" id="restriction_{{ $restriction->id }}" name="restrictions[]"
                                    value="{{ $restriction->id }}" class="form-check-input restriction-checkbox"
                                    data-name="{{ $restriction->restrictions }}"
                                    {{ in_array($restriction->id, old('restrictions', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="restriction_{{ $restriction->id }}">
                                    {{ $restriction->restrictions }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Ticket Details Section -->
            <div class="card form-section-card p-4">
                <div class="form-section-header">
                    <h5><i class="bi bi-list-check icon"></i> Select Required Ticket Details</h5>
                </div>
                <p class="text-muted mb-4">If any of the following conditions apply to your tickets, please select the corresponding options below.</p>
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="form-check">
                            <input type="checkbox" id="limitedView" name="limitedView" class="form-check-input" {{ old('limitedView') ? 'checked' : '' }}>
                            <label class="form-check-label" for="limitedView">Limited or restricted view</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check">
                            <input type="checkbox" id="vipPass" name="vipPass" class="form-check-input" {{ old('vipPass') ? 'checked' : '' }}>
                            <label class="form-check-label" for="vipPass">Includes VIP pass</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check">
                            <input type="checkbox" id="mealPackage" name="mealPackage" class="form-check-input" {{ old('mealPackage') ? 'checked' : '' }}>
                            <label class="form-check-label" for="mealPackage">Ticket and meal package</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check">
                            <input type="checkbox" id="parking" name="parking" class="form-check-input" {{ old('parking') ? 'checked' : '' }}>
                            <label class="form-check-label" for="parking">Includes parking</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check">
                            <input type="checkbox" id="standingOnly" name="standingOnly" class="form-check-input" {{ old('standingOnly') ? 'checked' : '' }}>
                            <label class="form-check-label" for="standingOnly">Standing Only</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check">
                            <input type="checkbox" id="aisleSeat" name="aisleSeat" class="form-check-input" {{ old('aisleSeat') ? 'checked' : '' }}>
                            <label class="form-check-label" for="aisleSeat">Aisle seat</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="mt-5 mb-5 text-center">
                <button type="submit" class="btn btn-submit">
                    <i class="bi bi-arrow-right-circle me-2"></i>Continue to Next Step
                </button>
            </div>

        </form>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.js"></script>
    <script>
        // Configure Toastr
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        // Display success message
        @if(session('success'))
            toastr.success("{{ session('success') }}", "Success!");
        @endif

        // Display error message
        @if(session('error'))
            toastr.error("{{ session('error') }}", "Error!");
        @endif

        document.addEventListener('DOMContentLoaded', function() {
            // Ticket quantity buttons
            const ticketButtons = document.querySelectorAll('.btn-ticket');
            const ticketInput = document.getElementById('ticketInput');
            const ticketDropdownContainer = document.getElementById('ticketDropdownContainer');
            const ticketDropdown = document.getElementById('ticketQuantity');
            const showDropdownButton = document.getElementById('showDropdown');
            const seatFromInput = document.querySelector("input[name='seat_from']");
            const seatToInput = document.querySelector("input[name='seat_to']");

            let selectedTickets = 0; // Store selected ticket count

            // Function to update the seat-to field
            function updateSeatTo() {
                let seatFrom = parseInt(seatFromInput.value) || 0;
                if (selectedTickets > 0 && seatFrom > 0) {
                    seatToInput.value = seatFrom + (selectedTickets - 1);
                } else {
                    seatToInput.value = ""; // Clear if invalid
                }
            }

            // Disable seat-to input
            seatToInput.readOnly = true;

            // Handle button clicks for ticket quantity
            ticketButtons.forEach(button => {
                button.addEventListener('click', function() {
                    ticketButtons.forEach(btn => btn.classList.remove('active'));

                    // Add active class to clicked button
                    this.classList.add('active');

                    // Set ticket count
                    selectedTickets = parseInt(this.getAttribute('data-value')) || 0;
                    ticketInput.value = selectedTickets;

                    // Hide dropdown if visible
                    ticketDropdownContainer.classList.add('d-none');

                    // Reset dropdown selection
                    ticketDropdown.value = "";

                    // Update seat-to if seat-from is already filled
                    updateSeatTo();
                });
            });

            // Handle "6+" button click to show dropdown
            if (showDropdownButton) {
                showDropdownButton.addEventListener('click', function() {
                    ticketButtons.forEach(btn => btn.classList.remove('active'));

                    // Clear input since dropdown will be used
                    ticketInput.value = "";
                    selectedTickets = 0; // Reset ticket count

                    // Show dropdown
                    ticketDropdownContainer.classList.remove('d-none');
                });
            }

            // Handle dropdown selection for ticket quantity
            if (ticketDropdown) {
                ticketDropdown.addEventListener('change', function() {
                    selectedTickets = parseInt(this.value) || 0;
                    ticketInput.value = selectedTickets;

                    // Update seat-to if seat-from is already filled
                    updateSeatTo();
                });
            }

            // Handle seat-from input change
            seatFromInput.addEventListener("input", updateSeatTo);

            // Toggle limited view checkbox

            function selectTicketType(typeId, typeName) {
                document.querySelectorAll('.ticket-type').forEach(card => {
                    card.classList.remove('border-primary');
                });

                event.currentTarget.classList.add('border-primary');

                document.getElementById('ticketTypeInput').value = typeId;
                // console.log("Set ticket type to:", typeId);

                document.querySelectorAll('.mobile-app-select').forEach(select => {
                    select.classList.add('d-none');
                });

                if (typeName.toLowerCase().includes('mobile') && typeName.toLowerCase().includes('transfer')) {
                    const mobileAppSelect = document.getElementById('mobileAppSelect-' + typeId);
                    if (mobileAppSelect) {
                        mobileAppSelect.classList.remove('d-none');
                    }
                } else {
                    document.getElementById('mobileAppInput').value = ''; // Clear mobile app value
                }
            }

            // Make selectTicketType globally accessible
            window.selectTicketType = selectTicketType;

            // Update mobile app selection
            const mobileAppSelect = document.getElementById('mobileApp');
            if (mobileAppSelect) {
                mobileAppSelect.addEventListener('change', function() {
                    document.getElementById('mobileAppInput').value = this.value;
                    // console.log("Set mobile app to:", this.value);
                });
            }

            // Form validation before submit
            const form = document.getElementById('ticketForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    let hasErrors = false;
                    let errorMessages = [];

                    // Check if ticket count is selected
                    if (!ticketInput.value) {
                        hasErrors = true;
                        errorMessages.push('Please select the number of tickets');
                    }

                    // Check if ticket type is selected
                    const ticketTypeInput = document.getElementById('ticketTypeInput');
                    if (!ticketTypeInput.value) {
                        hasErrors = true;
                        errorMessages.push('Please select a ticket type');
                    }

                    // Check if venue seating is selected
                    const venueSeating = document.querySelector('select[name="venue_seating"]');
                    if (!venueSeating.value) {
                        hasErrors = true;
                        errorMessages.push('Please select a section');
                    }

                    // Check if sell together is selected
                    const sellTogether = document.querySelector('input[name="sell_together"]:checked');
                    if (!sellTogether) {
                        hasErrors = true;
                        errorMessages.push('Please select whether to sell tickets together');
                    }

                    // Check if currency is selected
                    const currency = document.getElementById('currency');
                    if (!currency.value || currency.value === 'Select') {
                        hasErrors = true;
                        errorMessages.push('Please select a currency');
                    }

                    // Check if amount is entered
                    const amount = document.getElementById('amount');
                    if (!amount.value || parseFloat(amount.value) <= 0) {
                        hasErrors = true;
                        errorMessages.push('Please enter a valid amount');
                    }

                    // Check if mobile app is selected for mobile transfer
                    if (ticketTypeInput.value) {
                        const ticketTypeName = document.querySelector(`.ticket-type[onclick*="'${ticketTypeInput.value}'"]`);
                        if (ticketTypeName && ticketTypeName.textContent.toLowerCase().includes('mobile') && ticketTypeName.textContent.toLowerCase().includes('transfer')) {
                            const mobileAppInput = document.getElementById('mobileAppInput');
                            if (!mobileAppInput || !mobileAppInput.value) {
                                hasErrors = true;
                                errorMessages.push('Please select a mobile application for mobile ticket transfer');
                            }
                        }
                    }

                    if (hasErrors) {
                        e.preventDefault();
                        toastr.error(errorMessages.join('<br>'), 'Validation Error', {
                            timeOut: 8000,
                            extendedTimeOut: 2000
                        });
                        return false;
                    }

                    // Show loading message
                    toastr.info('Creating ticket, please wait...', 'Processing');
                });
            }

            // Handle No Restrictions checkbox to disable other restrictions
            const noRestrictionsCheckbox = document.querySelector(
                'input[type="checkbox"][data-name="NO RESTRICTIONS"]');

            if (noRestrictionsCheckbox) {
                noRestrictionsCheckbox.addEventListener("change", function() {
                    const restrictionCheckboxes = document.querySelectorAll(
                        'input[type="checkbox"].restriction-checkbox:not([data-name="NO RESTRICTIONS"])'
                    );

                    restrictionCheckboxes.forEach((checkbox) => {
                        checkbox.disabled = this.checked;
                        if (this.checked) {
                            checkbox.checked = false;
                        }
                    });
                });
            }

            // Ensure if any other checkbox is checked, "No Restrictions" is unchecked
            const allRestrictions = document.querySelectorAll('input[type="checkbox"].restriction-checkbox');

            allRestrictions.forEach((checkbox) => {
                checkbox.addEventListener("change", function() {
                    if (this.checked && this.dataset.name !== "NO RESTRICTIONS") {
                        noRestrictionsCheckbox.checked = false;
                        noRestrictionsCheckbox.disabled = false;
                    }
                });
            });

            //currency conversion calculation

            let currentRate = 0; // Store the current rate

            // When currency changes
            document.getElementById('currency').addEventListener('change', async function() {
                let selectedOption = this.options[this.selectedIndex];
                let currencyCode = selectedOption.getAttribute('data-code') || '💱';
                let currencyId = this.value;

                // Update the currency code display
                document.getElementById('currency-code').textContent = currencyCode;

                if (currencyId) {
                    try {
                        let response = await fetch(`/get-currency-rate/${currencyId}`);
                        let data = await response.json();

                        if (data.rate) {
                            currentRate = data.rate; // Store the rate
                            console.log(`Rate for ${currencyCode}:`, currentRate);

                            // If there's an existing value, calculate the conversion
                            let amount = parseFloat(document.getElementById('amount').value) || 0;
                            let cents = parseFloat(document.getElementById('cents').value) || 0;
                            updateConvertedValue(amount, cents);
                        } else {
                            alert('Failed to fetch conversion rate.');
                        }
                    } catch (error) {
                        console.error('Error fetching currency rate:', error);
                        alert('Error fetching conversion rate.');
                    }
                }
            });

            // When amount or cents change
            document.getElementById('amount').addEventListener('input', function() {
                let amount = parseFloat(this.value) || 0;
                let cents = parseFloat(document.getElementById('cents').value) || 0;
                updateConvertedValue(amount, cents);
            });

            document.getElementById('cents').addEventListener('input', function() {
                let amount = parseFloat(document.getElementById('amount').value) || 0;
                let cents = parseFloat(this.value) || 0;
                updateConvertedValue(amount, cents);
            });

            // Function to calculate and update the converted value
            function updateConvertedValue(amount, cents) {
                let total = amount + (cents / 100); // Combine amount + cents
                if (currentRate) {
                    let convertedValue = (total * currentRate).toFixed(2);
                    document.getElementById('converted-value').textContent = `$${convertedValue} USD`;
                }
            }
        });
    </script>
</body>

</html>
