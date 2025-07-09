<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose payment method</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        .card-input-element:checked+.selected-payment {
            background-color: #e6f7ff;
            border: 2px solid #007bff;
        }

        .modal-footer .btn {
            background-color: #dcdcdc;
            border: none;
        }

        .modal-footer .btn:enabled {
            background-color: #007bff;
            color: white;
        }

        .alert {
            transition: opacity 0.5s ease-out;
        }

        .card-input {
            cursor: pointer;
        }
    </style>
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
                            <li><a class="dropdown-item" href="{{ route('reseller.profile') }}">My Profile</a></li>
                            <li><a class="dropdown-item" href="#">Settings</a></li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                            <li>
                                <a class="dropdown-item" href="#"onclick="event.preventDefault();
                                  document.getElementById('logout-form').submit();">Log Out</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main content -->
    <div class="container my-5">
        @if (session('success'))
            <div id="successMessage" class="alert alert-success text-center">
                {{ session('success') }}
            </div>
        @endif

        <div class="row">
            <!-- Left Section - Form -->
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="fw-bold text-center">Choose Method for Getting Paid</h5>
                        <form id="ticketForm" action="{{ route('savePaymentMethod') }}" method="POST">
                            @csrf
                            <!-- Payment Methods -->
                            <div class="row mt-3 row-cols-1 row-cols-md-2 g-3">
                                @foreach ($bankDetails as $detail)
                                    <div class="col">
                                        <input type="radio" name="payment_method" class="card-input-element d-none"
                                            id="payment-{{ $detail->id }}" value="{{ $detail->id }}"
                                            data-payment-type="bank_transfer" required>
                                        <label for="payment-{{ $detail->id }}" class="w-100">
                                            <div class="card card-body border-success shadow-sm text-center min-vh-25 py-5 card-input"
                                                style="max-height: 160px;">
                                                <h6 class="mb-0">
                                                    {{ $detail->bank_name }} ({{ $detail->currency->short_name }})
                                                    <i class="bi bi-exclamation-circle text-warning ms-2"
                                                        onclick="alert('To update this account, click Add a new payment option and enter the new details.')"
                                                        title="To update this account, click Add a new payment option and enter the new details."></i>
                                                </h6>
                                                <p class="text-muted small">Account:
                                                    {{ str_repeat('*', strlen($detail->account_number) - 4) . substr($detail->account_number, -4) }}
                                                </p>
                                                <p class="text-muted small">Account Holder:
                                                    {{ $detail->account_holder_name }}
                                                </p>
                                            </div>
                                        </label>
                                    </div>
                                @endforeach

                                <div class="col">
                                    <label class="w-100" data-bs-toggle="modal" data-bs-target="#addPaymentModal">
                                        <div
                                            class="card card-body border-success text-center shadow-sm min-vh-25 py-5 card-input">
                                            <h6 class="mb-0">Add a new payment option</h6>
                                            <i class="bi bi-plus-circle fs-3 text-muted"></i>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Hidden Input to Store Payment Type -->
                            <input type="hidden" name="payment_type" id="paymentType">

                            <!-- Submit Button -->
                            <div class="mt-4">
                                <button type="submit" class="btn btn-success w-100">Continue</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Add New Payment Option Modal -->
            <div class="modal fade" id="addPaymentModal" tabindex="-1" aria-labelledby="addPaymentModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addPaymentModalLabel">Add New Payment Method</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Where would you like to receive funds from ticket sales?</p>

                            <div class="form-check d-flex align-items-center">
                                <input class="form-check-input me-2" type="radio" name="paymentMethod"
                                    id="bankTransferOption">
                                <label class="form-check-label d-flex align-items-center" for="bankTransferOption">
                                    <img src="{{ asset('admin_assets/img/payments/bank-transfer-svgrepo-com (1).svg') }}"
                                        alt="Bank Transfer" width="55" class="me-1"> Bank
                                    Transfer
                                </label>
                            </div>

                            <div class="form-check mt-2 d-flex align-items-center">
                                <input class="form-check-input me-2" type="radio" name="paymentMethod"
                                    id="paypalOption">
                                <label class="form-check-label d-flex align-items-center" for="paypalOption">
                                    <img src="{{ asset('admin_assets/img/payments/paypal.svg') }}" alt="PayPal"
                                        width="55" class="me-1">PayPal
                                </label>
                            </div>

                            <button type="button" class="btn btn-primary w-100 mt-3" id="continuePaymentBtn"
                                disabled>Continue</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bank Transfer Modal -->
            <div class="modal fade" id="bankTransferModal" tabindex="-1" aria-labelledby="bankTransferModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="bankTransferModalLabel">Bank Transfer Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="bankTransferForm" method="POST" action="{{ route('bank.details.store') }}">
                                @csrf
                                <!-- Currency Field -->
                                <div class="mb-3">
                                    <label for="currency" class="form-label">Currency</label>
                                    <select class="form-select" name="currency" id="currency" required>
                                        <option value="" disabled selected>Select a currency</option>
                                        @foreach ($currencys as $val)
                                            <option {{ $data->amount_currency == $val->id ? 'selected' : '' }}
                                                value="{{ $val->id }}">
                                                {{ $val->symbol . $val->name }}
                                            </option>
                                        @endforeach
                                        <!-- Add more currencies as needed -->
                                    </select>
                                </div>

                                <!-- Bank Name Field -->
                                <div class="mb-3">
                                    <label for="bankName" class="form-label">Bank Name</label>
                                    <input type="text" class="form-control" id="bankName"
                                        placeholder="American Bank" name="bank_name" required>
                                </div>

                                <!-- Account Holder Name Field -->
                                <div class="mb-3">
                                    <label for="accountHolderName" class="form-label">Account Holder Name</label>
                                    <input type="text" class="form-control" name="account_holder_name"
                                        id="accountHolderName" placeholder="John Doe" required>
                                </div>

                                <!-- Account Number Field -->
                                <div class="mb-3">
                                    <label for="accountNumber" class="form-label">Account Number (IBAN)</label>
                                    <input type="text" class="form-control" name="account_number"
                                        id="accountNumber" placeholder="xxx xxxx xxxxxx" required>
                                </div>

                                <!-- Routing Number (or SWIFT Code) Field -->
                                <div class="mb-3">
                                    <label for="routingNumber" class="form-label">Routing Number (or SWIFT
                                        Code)</label>
                                    <input type="text" class="form-control" name="routing_number"
                                        id="routingNumber" placeholder="Bank SWIFT code" required>
                                </div>

                                <!-- Additional Notes Field -->
                                <div class="mb-3">
                                    <label for="additionalNotes" class="form-label">Additional Notes
                                        (Optional)</label>
                                    <textarea class="form-control" name="additional_notes" id="additionalNotes" rows="3"
                                        placeholder="Add any additional notes here"></textarea>
                                </div>

                                <!-- Save Button -->
                                <button type="submit" class="btn btn-primary w-100">Save Bank Details</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PayPal Modal -->
            <div class="modal fade" id="paypalModal" tabindex="-1" aria-labelledby="paypalModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="paypalModalLabel">Connect PayPal</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Click below to connect your PayPal account for receiving funds.</p>
                            <button class="btn btn-primary w-100">Connect PayPal</button>
                        </div>
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
                                <span id="price-per-ticket">{{ $data->symbol }}{{ $data->ticket_amount }}.00</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <strong>Number of Tickets:</strong>
                                <span id="num-tickets">{{ $data->no_of_tickets }}</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <strong>Website Price:</strong>
                                <span id="website-price">{{ $data->symbol }}{{ $data->web_price }}.00</span>
                            </div>
                            <div class="d-flex justify-content-between text-danger">
                                <strong>Seller Fees:</strong>
                                <span id="seller-fee">-{{ $data->symbol }}{{ $data->seller_fee }}.00</span>
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <h5 class="fw-bold text-success">YOU'LL RECEIVE: </h5>
                            <h5 class="fw-bold text-success"><span
                                    id="total-amount">{{ $data->symbol }}{{ $data->total_recive }}</span>
                            </h5>
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
        document.addEventListener("DOMContentLoaded", function() {
            // Main Form: Handle Payment Method Selection
            const paymentInputs = document.querySelectorAll(
                "input[name='payment_method'], input[name='paymentMethod']");
            const paymentTypeInput = document.getElementById("paymentType");
            const continueButton = document.querySelector("button[type='submit']");
            const addPaymentModal = new bootstrap.Modal(document.getElementById("addPaymentModal"));
            const continueBtn = document.getElementById("continuePaymentBtn");
            const successMessage = document.getElementById("successMessage");

            // Disable the "Continue" button by default
            if (continueButton) continueButton.setAttribute("disabled", true);

            // Enable the button and set payment type when a radio is selected
            paymentInputs.forEach(input => {
                input.addEventListener("change", (e) => {
                    if (paymentTypeInput) {
                        paymentTypeInput.value = e.target.dataset
                            .paymentType; // Set dynamic payment type
                    }
                    if (continueButton) {
                        continueButton.removeAttribute("disabled"); // Enable main form button
                    }
                    if (continueBtn) {
                        continueBtn.removeAttribute("disabled"); // Enable modal button
                    }
                });
            });

            // Modal: Handle Continue Button Click
            if (continueBtn) {
                continueBtn.addEventListener("click", function() {
                    const selectedOption = document.querySelector("input[name='paymentMethod']:checked");
                    if (selectedOption) {
                        const targetModalId =
                            selectedOption.id === "bankTransferOption" ? "#bankTransferModal" :
                            "#paypalModal";

                        const targetModalElement = document.querySelector(targetModalId);
                        if (targetModalElement) {
                            const targetModal = new bootstrap.Modal(targetModalElement);
                            addPaymentModal.hide();
                            targetModal.show();

                            targetModalElement.addEventListener("hidden.bs.modal", function() {
                                addPaymentModal.show();
                            });
                        }
                    }
                });
            }

            // Fade Out Success Message
            if (successMessage) {
                setTimeout(() => {
                    successMessage.style.opacity = '0';
                    setTimeout(() => successMessage.remove(), 500);
                }, 5000);
            }
        });
    </script>
