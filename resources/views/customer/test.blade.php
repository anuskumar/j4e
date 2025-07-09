                                <!-- /Personal Information -->

                                <div class="payment-widget">
                                    <h4 class="card-title">Payment Method</h4>

                                    <!-- Credit Card Payment -->
                                    <div class="payment-list">
                                        <label class="payment-radio credit-card-option">
                                            <input type="radio" name="radio" checked>
                                            <span class="checkmark"></span>
                                            Credit/Debit Card
                                        </label>
                                        <div class="row">
                                            @if (Session::has('success'))
                                            <div class="alert alert-success text-center">
                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                                                <p>{{ Session::get('success') }}</p>
                                            </div>
                                        @endif


                                    @csrf

                                    <script
                                            src="https://checkout.stripe.com/checkout.js"
                                            class="stripe-button"
                                            data-key="{{ config('services.stripe.key') }}"
                                            data-amount="{{ round($data->web_price * $ticket_count *100) }}"
                                            data-locale="auto"
                                            data-currency="usd"
                                        ></script>


                                </div>
