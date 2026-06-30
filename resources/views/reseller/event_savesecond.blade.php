@extends('layouts.reseller_app')

@section('title', 'Set your ticket price')

@section('content')
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
                        <p class="mb-1"><strong>Event Type:</strong> {{ $data->event_type_name ?? 'N/A' }}</p>
                        <p class="mb-1"><strong>Tag:</strong> {{ $data->tag_name ?? 'N/A' }}</p>
                        <p class="mb-1">
                            <strong>Event Duration:</strong>
                            {{ !empty($data->event_from_date) ? \Carbon\Carbon::parse($data->event_from_date)->format('d M Y') : 'N/A' }}
                            -
                            {{ !empty($data->event_to_date) ? \Carbon\Carbon::parse($data->event_to_date)->format('d M Y') : 'N/A' }}
                        </p>
                        <p class="mb-1">
                            <strong>Date:</strong>
                            {{ strftime('%A, %d %B %Y', strtotime($data->event_date)) }}
                            {{ date('h:i A', strtotime($data->from_time)) }} - {{ date('h:i A', strtotime($data->to_time)) }}
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
                                <strong>Seller Fee/Ticket:</strong>
                                <span id="seller-fee-per-ticket">0.00</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <strong>Receive/Ticket:</strong>
                                <span id="receive-per-ticket">0.00</span>
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
                            <div class="d-flex justify-content-between">
                                <strong>Seller Fee %:</strong>
                                <span>{{ $data->seller_fee_percent ?? 10 }}%</span>
                            </div>
                            <div class="d-flex justify-content-between text-success">
                                <strong>Total Receive:</strong>
                                <span id="total-receive-label">0.00</span>
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
@endsection

@push('scripts')
    <script>
        let currentRate = 1;

        function updateSummary() {
            let amount = parseFloat(document.getElementById('amount').value) || 0;
            let cents = parseFloat(document.getElementById('cents').value) || 0;
            let pricePerTicket = amount + (cents / 100);

            let numTickets = parseInt(document.getElementById('num-tickets').textContent) || 0;
            let websitePrice = pricePerTicket * numTickets;
            const sellerFeePercent = parseFloat("{{ $data->seller_fee_percent ?? 10 }}") || 10;
            let sellerFees = websitePrice * (sellerFeePercent / 100);
            let totalAmount = websitePrice - sellerFees;
            let sellerFeePerTicket = numTickets > 0 ? (sellerFees / numTickets) : 0;
            let receivePerTicket = pricePerTicket - sellerFeePerTicket;

            // Apply conversion rate (if available)
            let convertedPricePerTicket = currentRate ? (pricePerTicket * currentRate).toFixed(2) : pricePerTicket.toFixed(
                2);
            let convertedWebsitePrice = currentRate ? (websitePrice * currentRate).toFixed(2) : websitePrice.toFixed(2);
            let convertedSellerFee = currentRate ? (sellerFees * currentRate).toFixed(2) : sellerFees.toFixed(2);
            let convertedTotalAmount = currentRate ? (totalAmount * currentRate).toFixed(2) : totalAmount.toFixed(2);
            let convertedSellerFeePerTicket = currentRate ? (sellerFeePerTicket * currentRate).toFixed(2) : sellerFeePerTicket.toFixed(2);
            let convertedReceivePerTicket = currentRate ? (receivePerTicket * currentRate).toFixed(2) : receivePerTicket.toFixed(2);

            let currencyCode = document.getElementById('currency-code').textContent || '💱';

            // Update UI with converted values
            document.getElementById('price-per-ticket').textContent = `${currencyCode} ${convertedPricePerTicket}`;
            document.getElementById('seller-fee-per-ticket').textContent = `-${currencyCode} ${convertedSellerFeePerTicket}`;
            document.getElementById('receive-per-ticket').textContent = `${currencyCode} ${convertedReceivePerTicket}`;
            document.getElementById('website-price').textContent = `${currencyCode} ${convertedWebsitePrice}`;
            document.getElementById('seller-fee').textContent = `-${currencyCode} ${convertedSellerFee}`;
            document.getElementById('total-amount').textContent = `${currencyCode} ${convertedTotalAmount}`;
            document.getElementById('total-receive-label').textContent = `${currencyCode} ${convertedTotalAmount}`;

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
@endpush
