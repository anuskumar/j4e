<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sell Events Tickets</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        .btn-ticket {
            flex: 1;
            /* Makes buttons evenly distribute space */
            min-width: 50px;
            /* Ensures buttons don’t shrink too much */
            max-width: 80px;
            /* Prevents buttons from getting too wide */
            padding: 8px 12px;
            /* Keeps padding balanced */
            font-size: 16px;
            /* Ensures readability */
            background-color: rgb(219, 216, 216);
            border: none;
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
        <form method="POST" action="{{ route('reseller.sellticketsave', ['id' => $id]) }}"
            enctype="multipart/form-data">
            @csrf
            {{-- @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif --}}
            <!-- Enter Number of Tickets -->
            <div class="card p-3 mb-3">
                <h6 class="fw-bold">Select Number of Tickets <span class="text-danger">*</span></h6>
                <p class="text-muted small">
                    If seat numbers are specified on your tickets, all tickets must be consecutive.
                    For non-consecutive tickets, you must create separate listings.
                </p>
                <div class="d-flex gap-2 flex-wrap">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                    <button type="button" class="btn btn-outline-secondary ticket-btn btn-ticket"
                        data-value="<?= $i ?>"><?= $i ?></button>
                    <?php endfor; ?>
                    <button type="button" class="btn btn-outline-secondary btn-ticket" id="showDropdown">6+</button>
                </div>

                <!-- Hidden input to store the selected value -->
                <input type="hidden" id="ticketInput" name="ticket_count" value="">
                @error('ticket_count')
                    <div class="text-danger">{{ $message }}</div>
                @enderror

                <div id="ticketDropdownContainer" class="mt-2 d-none">
                    <label for="ticketQuantity" class="form-label fw-bold">Select Quantity</label>
                    <select id="ticketQuantity" class="form-select">
                        <option selected value="">Select Tickets</option>
                        <?php for ($i = 6; $i <= 30; $i++): ?>
                        <option value="<?= $i ?>"><?= $i ?> Tickets</option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>


            <!-- Enter Seating Details -->
            <div class="card p-3 mb-3">
                <h5 class="fw-bold">Enter Seating Details <span class="text-danger fs-6">*</span></h5>
                <p class="text-muted small">You are required to provide section, row, and seat information if
                    available. Listings can be updated using My Account.</p>

                <div class="mb-3">
                    <label class="form-label" for="venue_seating">Section <span class="text-danger">*</span></label>
                    <select class="form-select" name="venue_seating" id="venue_seating">
                        <option value="">Please select...</option>
                        @foreach ($venue_seatings as $seating)
                            <option value="{{ $seating->id }}">
                                {{ $seating->seating_type_name ?? 'Unnamed Section' }}
                            </option>
                        @endforeach
                    </select>
                    @error('venue_seating')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>


                <div class="mb-3">
                    <label class="form-label">Row (Enter a single letter (A-Z)) <span
                            class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="row" placeholder="A or Z"
                        value="{{ old('row') }}" maxlength="1">
                    @error('row')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Seat Number (0 - 99) <span class="text-danger">*</span></label>
                    <div class="d-flex gap-2">
                        <input type="text" class="form-control" name="seat_from" value="{{ old('seat_from') }}"
                            placeholder="Seat From" maxlength="2">
                        <span class="align-self-center">to</span>
                        <input type="text" class="form-control" name="seat_to" placeholder="Seat to field is auto-filled based on ticket count and seat from"
                            value="{{ old('seat_to') }}" maxlength="2">
                        @error('seat_to')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-5">
                    <label class="form-label">If you are unable to provide seating information, please select a
                        reason:</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="seat_reason" id="reason1"
                            value="not_provided">
                        <label class="form-check-label" for="reason1">The primary site has not provided me with this
                            information</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="seat_reason" id="reason2"
                            value="other">
                        <label class="form-check-label" for="reason2">Other</label>
                    </div>
                </div>

                <!-- selecting ticket Details -->

                <div class="mb-3">
                    <label class="form-label fw-bold text-muted">Do you want to sell all your tickets together?</label>
                    @foreach ($splittypes as $split)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="sell_together"
                                id="sell_{{ $split->id }}" value="{{ $split->id }}">
                            <label class="form-check-label"
                                for="sell_{{ $split->id }}">{{ $split->split_name }}</label>
                        </div>
                    @endforeach
                </div>


            </div>
            <div class="alert alert-success d-flex align-items-center" role="alert">
                <i class="bi bi-check-circle me-2"></i>
                <span>Unlike other sites, it is always free to list your tickets for sale on Just 4 Entertainment</span>
            </div>

            <!-- Enter Face Value Section -->
            <div class="card mb-3" style="max-width: 100%;">
                <div class="card-body">
                    <h6 class="fw-bold">Enter Face Value</h6>
                    <div class="alert alert-light d-flex align-items-center" role="alert">
                        <i class="bi bi-info-circle me-2"></i>
                        <span>Face value is the price printed on the ticket, excluding any booking fees.</span>
                    </div>

                    <div class="row g-2">
                        {{-- Currency Dropdown --}}
                        <div class="col-md-4">
                            <label for="currency" class="form-label">Currency</label>
                            <select class="form-select" id="currency" name="currency">
                                <option selected>Select</option>
                                @foreach ($currency as $val)
                                    <option value="{{ $val->id }}" data-code="{{ $val->short_name }}">
                                        {{ $val->symbol . ' ' . $val->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Amount Input --}}
                        <div class="col-md-3">
                            <label for="amount" class="form-label">Amount (Price per ticket)</label>
                            <div class="input-group">
                                <span class="input-group-text" id="currency-code">💱</span>
                                <input type="text" class="form-control" id="amount" name="amount"
                                    placeholder="0">
                            </div>
                        </div>

                        {{-- Cents Input --}}
                        <div class="col-md-2">
                            <label for="cents" class="form-label">Cents</label>
                            <input type="text" class="form-control" id="cents" name="cents"
                                placeholder="00" maxlength="2">
                        </div>

                        {{-- Converted Value Display --}}
                        <div class="col-md-3 d-flex align-items-center">
                            <div>
                                <label class="form-label">Converted Value</label>
                                <div id="converted-value" class="fw-bold">$0.00 USD</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <!-- Ticket type Section -->
            <div class="mt-4">
                <div class="card mb-3 p-4">
                    <h5 class="fw-bold">Choose Ticket Type</h5>
                    <div class="row g-3">
                        <input type="hidden" id="ticketTypeInput" name="ticket_type" value="">
                        @foreach ($ticket_type as $type)
                            <div class="col-md-6">
                                <div class="card ticket-type p-3"
                                    style="background-color: {{ $type->background_color ?? ($loop->iteration % 2 == 0 ? '#add8e6' : '#90ee90') }};"
                                    onclick="selectTicketType('{{ $type->id }}', '{{ $type->ticket_type_name }}')">
                                    <h6 class="fw-bold">{{ $type->ticket_type_name }}</h6>
                                    <p class="text-muted mb-0">{{ $type->description }}</p>
                                </div>

                                <!-- Mobile App dropdown section within the same column -->
                                @if (strtolower($type->ticket_type_name) == 'mobile ticket transfer' ||
                                        (strpos(strtolower($type->ticket_type_name), 'mobile') !== false &&
                                            strpos(strtolower($type->ticket_type_name), 'transfer') !== false))
                                    <div id="mobileAppSelect-{{ $type->id }}"
                                        class="mt-2 d-none mobile-app-select">
                                        <input type="hidden" id="mobileAppInput" name="mobile_app" value="">
                                        <label for="mobileApp" class="form-label">Mobile Application:</label>
                                        <select id="mobileApp" class="form-select">
                                            <option selected>Select an application</option>
                                            @foreach ($mobile_applications as $app)
                                                <option value="{{ $app->id }}">{{ $app->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="alert alert-success d-flex align-items-center mt-3" role="alert">
                <i class="bi bi-ticket me-2"></i>
                <span>99 buyers are currently searching for tickets for this event. Now is a good time to
                    sell!</span>
            </div>

            <!-- Restriction and requirements Section -->
            <div class="mt-4">
                <div class="card mb-3 p-4">
                    <h5 class="fw-bold">Select Restrictions on Use</h5>
                    <p>If any of the following conditions apply to your tickets, please select them from the list below.
                    </p>
                    <div class="row g-3">
                        @foreach ($restrictions as $restriction)
                            <div class="col-md-4">
                                <input type="checkbox" id="restriction_{{ $restriction->id }}" name="restrictions[]"
                                    value="{{ $restriction->id }}" class="restriction-checkbox"
                                    data-name="{{ $restriction->restrictions }}">
                                <label
                                    for="restriction_{{ $restriction->id }}">{{ $restriction->restrictions }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>


            <div class="mt-4">
                <div class="card mb-3 p-4">
                    <h5 class="fw-bold">Select Required Ticket Details</h5>
                    <p>If any of the following conditions apply to your tickets, please select the corresponding options
                        below.</p>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <input type="checkbox" id="limitedView"> <label for="limitedView">Limited or restricted
                                view</label>
                        </div>
                        <div class="col-md-4">
                            <input type="checkbox" id="vipPass"> <label for="vipPass">Includes VIP pass</label>
                        </div>
                        <div class="col-md-4">
                            <input type="checkbox" id="mealPackage"> <label for="mealPackage">Ticket and meal
                                package</label>
                        </div>
                        <div class="col-md-4">
                            <input type="checkbox" id="parking"> <label for="parking">Includes parking</label>
                        </div>
                        <div class="col-md-4">
                            <input type="checkbox" id="standingOnly"> <label for="standingOnly">Standing Only</label>
                        </div>
                        <div class="col-md-4">
                            <input type="checkbox" id="aisleSeat"> <label for="aisleSeat">Aisle seat</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4 text-center">
                <button type="submit" class="btn btn-success px-5 w-50">Continue</button>
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
    <script>
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
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    // Check if ticket count is selected
                    if (!ticketInput.value) {
                        e.preventDefault();
                        alert('Please select the number of tickets');
                        return false;
                    }

                    // Check if ticket type is selected
                    const ticketTypeInput = document.getElementById('ticketTypeInput');
                    if (!ticketTypeInput.value) {
                        e.preventDefault();
                        alert('Please select a ticket type');
                        return false;
                    }

                    // Check if mobile app is selected for mobile transfer
                    if (ticketTypeInput.value === 'mobile-transfer') {
                        const mobileAppInput = document.getElementById('mobileAppInput');
                        if (!mobileAppInput.value) {
                            e.preventDefault();
                            alert('Please select a mobile application');
                            return false;
                        }
                    }

                    // Additional validation as needed
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
