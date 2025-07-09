@extends('layout.mainlayout')

@section('content')
<style type="text/css">
    .modal-header {
        background: linear-gradient(90deg, #dc3545, #f8d7da);
        color: white;
    }
</style>
<div class="container">
    <!-- Failed Modal -->
    <div class="modal fade" id="failedModal" tabindex="-1" aria-labelledby="failedModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg rounded">
                <div class="modal-header bg-light text-danger">
                    <h5 class="modal-title" id="failedModalLabel">
                        <i class="bi bi-x-circle-fill" style="color: #dc3545;"></i> Booking Failed!
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="modal-body text-center">
                    <h4 class="fw-bold">Oops, something went wrong!</h4>
                    <p class="mb-3">
                        Your booking couldn't be completed. Please try again later. <br>
                        <!-- <strong>Error Code:</strong> <span class="text-danger">#</span> -->
                    </p>
                    <p class="small text-muted">
                        If the issue persists, please contact our support team.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script to Trigger Failed Modal -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var failedModal = new bootstrap.Modal(document.getElementById('failedModal'), {
            keyboard: true
        });
        failedModal.show();

        var closeButtonHeader = document.querySelector('.btn-close');
        closeButtonHeader.addEventListener('click', function() {
            failedModal.hide();
        });
    });
</script>


@endsection