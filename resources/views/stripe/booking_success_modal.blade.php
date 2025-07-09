@extends('layout.mainlayout')

@section('content')
<style type="text/css">
    .modal-header {
        background: linear-gradient(90deg, #28a745, #85e085);
        color: white;
    }
</style>
<div class="container">
    <!-- Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg rounded">
                <div class="modal-header bg-light text-success">
                    <h5 class="modal-title" id="successModalLabel">
                        <i class="bi bi-check-circle-fill" style="color: #28a745;"></i> Booking Confirmed!
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="modal-body text-center">
                    <h4 class="fw-bold">Congratulations!</h4>
                    <p class="mb-3">
                        Your order has been confirmed. <br>
                        <strong>Order No:</strong> <span class="text-primary">#{{ $order_id }}</span>
                    </p>
                    <p class="small text-muted">
                        Thank you for booking with us. An email confirmation has been sent to your registered email.
                    </p>
                </div>
                <!-- <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                        Close
                    </button>
                </div> -->
            </div>
        </div>
    </div>
</div>

<!-- Script to Trigger and Handle Modal -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Initialize the modal
        var myModal = new bootstrap.Modal(document.getElementById('successModal'), {
            keyboard: true // Allow closing the modal with the Escape key
        });

        // Show the modal when the page loads
        myModal.show();
        
        // Ensure the close button in the header works
        var closeButtonHeader = document.querySelector('.btn-close');
        closeButtonHeader.addEventListener('click', function() {
            myModal.hide();
        });
    });
</script>

@endsection
