<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set your ticket price</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>

<body>
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
                            <li><a class="dropdown-item" href="{{ url('tickets') }}">My Tickets</a></li>
                            <li><a class="dropdown-item" href="#">My Sales</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="ticketDropdown" role="button"
                            data-bs-toggle="dropdown">My Tickets</a>
                        <ul class="dropdown-menu" aria-labelledby="ticketDropdown">
                            <li><a class="dropdown-item" href="#">Orders</a></li>
                            <li><a class="dropdown-item" href="{{ url('tickets') }}">My Tickets</a></li>
                            <li><a class="dropdown-item" href="#">My Sales</a></li>
                            <li><a class="dropdown-item" href="#">Payments</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button"
                            data-bs-toggle="dropdown">Profile <i class="bi bi-person"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="profileDropdown">
                            <li><a class="dropdown-item" href="#">My Hub</a></li>
                            <li><a class="dropdown-item" href="#">Settings</a></li>
                            <li><a class="dropdown-item" href="#">Log Out</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <div class="row">
            <!-- Left Section - Form -->
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="fw-bold">Set Your Price</h5>
                        <!-- Currency Dropdown -->
                        <form id="ticketForm"
                            action="{{ route('reseller.updateticket', ['id' => request()->route('id')]) }}"
                            method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="currency" class="form-label">Choose the currency in which you would like
                                    to
                                    be paid</label>
                                <select class="form-select" id="currency" name="currency">
                                    <option selected>Select</option>
                                    @foreach ($currencys as $val)
                                        <option {{ $data->amount_currency == $val->id ? 'selected' : '' }}
                                            value="{{ $val->id }}"
                                            data-code="{{ $val->symbol . $val->short_name }}"
                                            data-rate="{{ $val->currency_rate }}">
                                            {{ $val->symbol . $val->name }}
                                        </option>
                                    @endforeach
                                </select>

                            </div>

                            <!-- Amount and Cents -->
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="amount" class="form-label">Amount</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="currency-code">💱</span>
                                        <input type="number" value="{{ $data->ticket_amount }}" class="form-control"
                                            id="amount" name="amount" placeholder="0">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label for="cents" class="form-label">Cents</label>
                                    <input type="number" class="form-control" id="cents" name="cents"
                                        placeholder="00">
                                </div>
                                <div class="col-md-6 d-flex align-items-end">
                                    <span class="ms-2">Per Ticket</span>
                                </div>
                            </div>

                            <!-- Suggested Price Info -->
                            <div class="mt-3">
                                <small class="text-muted">
                                    * All currency conversions are based on US Dollar (USD) rates *.
                                </small>
                            </div>

                            <!-- Submit Button -->
                            <div class="mt-4">
                                <button type="submit" class="btn btn-success w-100">Continue</button>
                            </div>
                            <input type="hidden" id="converted_price_per_ticket" name="converted_price_per_ticket">
                            <input type="hidden" id="converted_website_price" name="converted_website_price">
                            <input type="hidden" id="converted_seller_fee" name="converted_seller_fee">
                            <input type="hidden" id="converted_total_receive" name="converted_total_receive">

                        </form>
                    </div>
                </div>
            </div>

            <!-- Right Section - Event Summary -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="fw-bold">Event Summary</h5>
                        <p class="mb-1"><strong>Event:</strong> {{ $data->event_name }}</p>
                        <p class="mb-1">
                            <strong>Date:</strong>
                            {{ strftime('%A, %d %B %Y', strtotime($data->event_date)) }}
                            {{ date('H:i', strtotime($data->from_time)) }}
                        </p>

                        <p class="mb-1"><strong>Venue:</strong> {{ $data->name }}, {{ $data->location_name }},
                            {{ $data->cname }}, {{ $data->country_name }} </p>

                        <!-- Tags Section -->
                        <div class="mb-2 mt-2">
                            <span class="badge bg-light text-dark me-1">Ticket Type:
                                <span id="ticket-type" class="text-muted">
                                    @if ($data->ticket_type_name === 'Mobile Ticket Transfer')
                                        {{ $data->ticket_type_name }} (via {{ $data->mobile_applications_name }})
                                    @else
                                        {{ $data->ticket_type_name }}
                                    @endif
                                </span>
                            </span>

                            <span class="badge bg-light text-dark me-1">Split Type: <span id="split-type"
                                    class="text-muted">{{ $data->split_name }}</span></span>
                            <span class="badge bg-light text-dark me-1">Section: <span id="section"
                                    class="text-muted">{{ $data->venue_seating_name }}</span></span>
                            <span class="badge bg-light text-dark">Row: <span id="row" class="text-muted">
                                    {{ $data->row }}</span></span>
                            <span class="badge bg-light text-dark">Seats: <span id="row" class="text-muted">
                                    {{ $data->seat_from }} To {{ $data->seat_to }}</span></span>
                        </div>

                        <hr>

                        <div>
                            <div class="d-flex justify-content-between">
                                <strong>Price/Ticket:</strong>
                                <span id="price-per-ticket">0.00</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <strong>Number of Tickets:</strong>
                                <span id="num-tickets">{{ $data->no_of_tickets }}</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <strong>Website Price:</strong>
                                <span id="website-price">0.00</span>
                            </div>
                            <div class="d-flex justify-content-between text-danger">
                                <strong>Seller Fees:</strong>
                                <span id="seller-fee">0.00</span>
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <h5 class="fw-bold text-success">YOU'LL RECEIVE: </h5>
                            <h5 class="fw-bold text-success"><span id="total-amount">0.00</span></h5>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

    <footer class="bg-light py-5 mt-5">
        <div class="container">
            <div class="row">
                <!-- Guarantee Section -->
                <div class="col-lg-4 col-md-6 text-md-start text-center">
                    <h5 class="fw-bold"><i class="bi bi-shield-check text-success"></i> Just 4 <span
                            style="color: #d20ae9;">
                            Entertainment</span> <span class="text-muted">Guarantee</span></h5>
                    <ul class="list-unstyled text-muted">
                        <li><i class="bi bi-check-circle text-success"></i> World class security checks</li>
                        <li><i class="bi bi-check-circle text-success"></i> Transparent pricing</li>
                        <li><i class="bi bi-check-circle text-success"></i> 100% order guarantee</li>
                        <li><i class="bi bi-check-circle text-success"></i> Customer service from start to finish</li>
                    </ul>
                </div>

                <!-- Our Company Section -->
                <div class="col-lg-3 col-md-6 text-md-start text-center">
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
                <div class="col-lg-2 col-md-6 text-md-start text-center">
                    <h5 class="fw-bold">Have Questions?</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-muted text-decoration-none">Help Center / Contact Us</a>
                        </li>
                    </ul>
                </div>

                <!-- Live Events Section -->
                <div class="col-lg-3 col-md-6 text-md-start text-center">
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
                <p class="mb-1">&copy; Just 4 Entertinment 2025 <a href="#"
                        class="text-decoration-none fw-bold">Company Details</a></p>
                <p class="small">
                    Use of this web site constitutes acceptance of the
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
        let currentRate = 1;

        function updateSummary() {
            let amount = parseFloat(document.getElementById('amount').value) || 0;
            let cents = parseFloat(document.getElementById('cents').value) || 0;
            let pricePerTicket = amount + (cents / 100);

            let numTickets = parseInt(document.getElementById('num-tickets').textContent) || 0;
            let websitePrice = pricePerTicket * numTickets;
            let sellerFees = websitePrice * 0.10; // 10% seller fee
            let totalAmount = websitePrice - sellerFees;

            // Apply conversion rate (if available)
            let convertedPricePerTicket = currentRate ? (pricePerTicket * currentRate).toFixed(2) : pricePerTicket.toFixed(
                2);
            let convertedWebsitePrice = currentRate ? (websitePrice * currentRate).toFixed(2) : websitePrice.toFixed(2);
            let convertedSellerFee = currentRate ? (sellerFees * currentRate).toFixed(2) : sellerFees.toFixed(2);
            let convertedTotalAmount = currentRate ? (totalAmount * currentRate).toFixed(2) : totalAmount.toFixed(2);

            let currencyCode = document.getElementById('currency-code').textContent || '💱';

            // Update UI with converted values
            document.getElementById('price-per-ticket').textContent = `${currencyCode} ${convertedPricePerTicket}`;
            document.getElementById('website-price').textContent = `${currencyCode} ${convertedWebsitePrice}`;
            document.getElementById('seller-fee').textContent = `-${currencyCode} ${convertedSellerFee}`;
            document.getElementById('total-amount').textContent = `${currencyCode} ${convertedTotalAmount}`;

            // Update hidden input fields for form submission
            document.getElementById('converted_price_per_ticket').value = convertedPricePerTicket;
            document.getElementById('converted_website_price').value = convertedWebsitePrice;
            document.getElementById('converted_seller_fee').value = convertedSellerFee;
            document.getElementById('converted_total_receive').value = convertedTotalAmount;
        }

        function setCurrencyData() {
            let selectedOption = document.getElementById('currency').options[document.getElementById('currency')
                .selectedIndex];
            document.getElementById('currency-code').textContent = selectedOption.getAttribute('data-code') || '💱';

            // Get the conversion rate from the option's data attribute
            currentRate = parseFloat(selectedOption.getAttribute('data-rate')) || 1; // Fallback to 1 if rate not available

            updateSummary(); // Trigger calculation after currency change
        }

        // Event Listeners
        document.getElementById('currency').addEventListener('change', setCurrencyData);
        document.getElementById('amount').addEventListener('input', updateSummary);
        document.getElementById('cents').addEventListener('input', updateSummary);

        // Trigger calculation on page load if values are pre-filled
        window.addEventListener('load', setCurrencyData);
    </script>


</body>

</html>
