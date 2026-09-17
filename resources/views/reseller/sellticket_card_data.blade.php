@extends('layouts.reseller_app')

@section('title', 'Choose payment method')

@push('styles')
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

        .event-summary-card {
            overflow: hidden;
            word-wrap: break-word;
            overflow-wrap: anywhere;
        }

        .event-summary-card .card-body {
            overflow: hidden;
            max-width: 100%;
        }

        .event-summary-card .summary-text {
            margin-bottom: 0.5rem;
            word-break: break-word;
            overflow-wrap: anywhere;
            white-space: normal;
        }

        .event-summary-card .summary-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 0.4rem;
            max-width: 100%;
        }

        .event-summary-card .summary-tags .badge {
            white-space: normal;
            text-align: left;
            line-height: 1.35;
            max-width: 100%;
            word-break: break-word;
            overflow-wrap: anywhere;
        }

        .event-summary-card .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 0.75rem;
            max-width: 100%;
        }

        .event-summary-card .summary-row > strong,
        .event-summary-card .summary-row > span,
        .event-summary-card .summary-row > h5 {
            min-width: 0;
            word-break: break-word;
            overflow-wrap: anywhere;
        }

        .event-summary-card .summary-row > span,
        .event-summary-card .summary-row > h5 {
            text-align: right;
            flex: 0 1 auto;
        }

        .event-summary-card .summary-row > strong {
            flex: 1 1 auto;
        }

        .event-summary-card .receive-row h5 {
            font-size: 1rem;
            margin-bottom: 0;
            line-height: 1.4;
        }
    </style>
@endpush

@section('content')
    <div class="container my-5">
        @if (session('success'))
            <div id="successMessage" class="alert alert-success text-center">
                {{ session('success') }}
            </div>
        @endif
        @if (session('warning'))
            <div class="alert alert-warning text-center">
                {{ session('warning') }}
            </div>
        @endif

        <div class="row">
            <!-- Left Section - Form -->
            <div class="col-lg-8">
                <form id="paymentForm" action="{{ route('savePaymentMethod') }}" method="POST">
                    @csrf
                    <input type="hidden" name="ticket_id" value="{{ request()->route('id') }}">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="fw-bold">Set Your Price</h5>
                            <div class="mb-3">
                                <label for="price-currency" class="form-label">
                                    Choose the currency in which you would like to be converted
                                </label>
                                <select class="form-select" id="price-currency" name="currency" required>
                                    <option value="">Select</option>
                                    @php
                                        $activeCurrencies = $currencys->where('is_active', 1)->values();
                                        $preferredCurrencyId = old('currency', $data->amount_currency);
                                        $preferredIsActive = $activeCurrencies->contains(function ($currency) use ($preferredCurrencyId) {
                                            return (string) $currency->id === (string) $preferredCurrencyId;
                                        });
                                        $usdCurrency = $activeCurrencies->first(function ($currency) {
                                            return strtoupper((string) $currency->short_name) === 'USD';
                                        });
                                        if (! $preferredIsActive) {
                                            $preferredCurrencyId = $usdCurrency->id ?? optional($activeCurrencies->first())->id;
                                        }
                                    @endphp
                                    @foreach ($currencys as $val)
                                        @php
                                            $isCurrencyActive = (int) $val->is_active === 1;
                                        @endphp
                                        <option value="{{ $val->id }}"
                                            data-code="{{ $val->short_name }}"
                                            data-symbol="{{ $val->symbol }}"
                                            data-rate="{{ $val->currency_rate }}"
                                            data-active="{{ $isCurrencyActive ? 1 : 0 }}"
                                            @disabled(! $isCurrencyActive)
                                            {{ (string) $preferredCurrencyId === (string) $val->id && $isCurrencyActive ? 'selected' : '' }}>
                                            {{ $val->symbol }} {{ $val->name }} ({{ $val->short_name }}){{ $isCurrencyActive ? '' : ' — Inactive' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <label for="price-amount" class="form-label">Amount</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="price-currency-code">💱</span>
                                        <input type="number" class="form-control" id="price-amount" name="amount"
                                            value="{{ old('amount', floor((float) $data->ticket_amount)) }}"
                                            placeholder="0" min="0" step="1" required>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label for="price-cents" class="form-label">Cents</label>
                                    <input type="number" class="form-control" id="price-cents" name="cents"
                                        value="{{ old('cents', str_pad((string) round((((float) $data->ticket_amount) - floor((float) $data->ticket_amount)) * 100), 2, '0', STR_PAD_LEFT)) }}"
                                        placeholder="00" min="0" max="99" step="1">
                                </div>
                                <div class="col-md-6 d-flex align-items-end">
                                    <span class="ms-2">Per Ticket</span>
                                </div>
                            </div>

                            <div class="alert alert-light border mt-3 mb-0 py-2 px-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <strong>Converted Price (USD):</strong>
                                    <span id="converted-usd-preview" class="fw-bold text-success">$0.00 USD</span>
                                </div>
                            </div>

                            <small class="text-muted d-block mt-3">
                                * Amounts below are converted and displayed in US Dollar (USD). Enter price in the selected currency; conversion always prioritizes USD *.
                            </small>

                            <input type="hidden" id="converted_price_per_ticket" name="converted_price_per_ticket">
                            <input type="hidden" id="converted_website_price" name="converted_website_price">
                            <input type="hidden" id="converted_seller_fee" name="converted_seller_fee">
                            <input type="hidden" id="converted_total_receive" name="converted_total_receive">
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="fw-bold text-center">Choose Method for Getting Paid</h5>
                            @if ($bankDetails->isEmpty())
                                <div class="alert alert-warning mt-3 mb-0" role="alert">
                                    <i class="bi bi-exclamation-triangle me-1"></i>
                                    Payment account details were not found. Please add your account details to continue.
                                </div>
                            @endif
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
                    </div>
                </div>
                </form>
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
                                            @php
                                                $isCurrencyActive = (int) $val->is_active === 1;
                                            @endphp
                                            <option value="{{ $val->id }}"
                                                @disabled(! $isCurrencyActive)
                                                {{ (string) $data->amount_currency === (string) $val->id && $isCurrencyActive ? 'selected' : '' }}>
                                                {{ $val->symbol }} {{ $val->name }} ({{ $val->short_name }}){{ $isCurrencyActive ? '' : ' — Inactive' }}
                                            </option>
                                        @endforeach
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
                <div class="card event-summary-card">
                    <div class="card-body">
                        <h5 class="fw-bold">Event Summary</h5>
                        <p class="summary-text"><strong>Event:</strong> {{ $data->event_name }}</p>
                        <p class="summary-text">
                            <strong>Date:</strong>
                            {{ strftime('%A, %d %B %Y', strtotime($data->event_date)) }}
                            {{ date('H:i', strtotime($data->from_time)) }}
                        </p>

                        <p class="summary-text"><strong>Venue:</strong> {{ $data->name }}, {{ $data->location_name }},
                            {{ $data->cname }}, {{ $data->country_name }} </p>

                        <!-- Tags Section -->
                        <div class="summary-tags mb-2 mt-2">
                            <span class="badge bg-light text-dark">Ticket Type:
                                <span id="ticket-type" class="text-muted">
                                    @if ($data->ticket_type_name === 'Mobile Ticket Transfer')
                                        {{ $data->ticket_type_name }} (via {{ $data->mobile_applications_name }})
                                    @else
                                        {{ $data->ticket_type_name }}
                                    @endif
                                </span>
                            </span>

                            <span class="badge bg-light text-dark">Split Type: <span id="split-type"
                                    class="text-muted">{{ $data->split_name }}</span></span>
                            <span class="badge bg-light text-dark">Section: <span id="section"
                                    class="text-muted">{{ $data->venue_seating_name }}</span></span>
                            <span class="badge bg-light text-dark">Row: <span id="row" class="text-muted">
                                    {{ $data->row }}</span></span>
                            <span class="badge bg-light text-dark">Seats: <span id="seats" class="text-muted">
                                    {{ $data->seat_from }} To {{ $data->seat_to }}</span></span>
                        </div>

                        <hr>

                        <div>
                            <div class="summary-row mb-2">
                                <strong>Price/Ticket (USD):</strong>
                                <span id="price-per-ticket">$0.00</span>
                            </div>
                            <div class="summary-row mb-2">
                                <strong>Number of Tickets:</strong>
                                <span id="num-tickets">{{ $data->no_of_tickets }}</span>
                            </div>
                            <hr>
                            <div class="summary-row mb-2">
                                <strong>Website Price (USD):</strong>
                                <span id="website-price">$0.00</span>
                            </div>
                            <div class="summary-row mb-2 text-danger">
                                <strong>Seller Fees (USD):</strong>
                                <span id="seller-fee">-$0.00</span>
                            </div>
                        </div>
                        <hr>
                        <div class="summary-row receive-row">
                            <h5 class="fw-bold text-success">YOU'LL RECEIVE (USD):</h5>
                            <h5 class="fw-bold text-success"><span id="total-amount">$0.00</span></h5>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const priceCurrency = document.getElementById('price-currency');
            const priceAmount = document.getElementById('price-amount');
            const priceCents = document.getElementById('price-cents');
            const ticketCount = parseInt(document.getElementById('num-tickets').textContent) || 0;
            const sellerFeePercent = parseFloat("{{ $data->seller_fee_percent ?? 10 }}") || 10;

            function updatePriceSummary() {
                const selectedCurrency = priceCurrency.options[priceCurrency.selectedIndex];
                if (selectedCurrency && selectedCurrency.dataset.active === '0') {
                    // Skip inactive currencies if somehow selected.
                    const activeOption = Array.from(priceCurrency.options).find((option) => option.value && option.dataset.active === '1');
                    if (activeOption) {
                        priceCurrency.value = activeOption.value;
                    }
                }

                const activeCurrency = priceCurrency.options[priceCurrency.selectedIndex];
                const currencyCode = activeCurrency?.dataset.code || '💱';
                const rate = parseFloat(activeCurrency?.dataset.rate) || 0;

                let amount = parseFloat(priceAmount.value);
                if (Number.isNaN(amount) || amount < 0) {
                    amount = 0;
                }

                let cents = parseInt(priceCents.value, 10);
                if (Number.isNaN(cents) || cents < 0) {
                    cents = 0;
                }
                if (cents > 99) {
                    cents = 99;
                    priceCents.value = 99;
                }

                // Entered price in selected currency (with cents).
                const enteredPrice = Math.round((amount + (cents / 100)) * 100) / 100;

                // Priority: always convert to USD.
                // currency_rate = units of selected currency per 1 USD.
                const safeRate = rate > 0 ? rate : 1;
                const pricePerTicketUsd = Math.round((enteredPrice / safeRate) * 100) / 100;
                const websitePriceUsd = Math.round((pricePerTicketUsd * ticketCount) * 100) / 100;
                const sellerFeeUsd = Math.round((websitePriceUsd * (sellerFeePercent / 100)) * 100) / 100;
                const totalReceiveUsd = Math.round((websitePriceUsd - sellerFeeUsd) * 100) / 100;

                const formatUsd = (value) => value.toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });

                document.getElementById('price-currency-code').textContent = currencyCode;
                document.getElementById('converted-usd-preview').textContent = `$${formatUsd(pricePerTicketUsd)} USD`;
                document.getElementById('price-per-ticket').textContent = `$${formatUsd(pricePerTicketUsd)}`;
                document.getElementById('website-price').textContent = `$${formatUsd(websitePriceUsd)}`;
                document.getElementById('seller-fee').textContent = `-$${formatUsd(sellerFeeUsd)}`;
                document.getElementById('total-amount').textContent = `$${formatUsd(totalReceiveUsd)}`;

                // Persist USD values for backend save.
                document.getElementById('converted_price_per_ticket').value = pricePerTicketUsd.toFixed(2);
                document.getElementById('converted_website_price').value = websitePriceUsd.toFixed(2);
                document.getElementById('converted_seller_fee').value = sellerFeeUsd.toFixed(2);
                document.getElementById('converted_total_receive').value = totalReceiveUsd.toFixed(2);
            }

            priceCurrency.addEventListener('change', updatePriceSummary);
            priceAmount.addEventListener('input', updatePriceSummary);
            priceCents.addEventListener('input', updatePriceSummary);
            updatePriceSummary();

            // Main Form: Handle Payment Method Selection
            const paymentInputs = document.querySelectorAll(
                "input[name='payment_method'], input[name='paymentMethod']");
            const paymentTypeInput = document.getElementById("paymentType");
            const continueButton = document.querySelector("#paymentForm button[type='submit']");
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
@endpush
