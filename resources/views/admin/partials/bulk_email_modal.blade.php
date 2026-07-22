@php
    $prefix = $emailPrefix ?? 'bulk';
    $modalId = $prefix . 'EmailModal';
    $recipientLabel = $recipientLabel ?? 'recipient';
    $recipientPlural = Str::plural($recipientLabel);
    $recipientOptions = collect($recipients)->map(function ($recipient) {
        return [
            'id' => $recipient->id,
            'name' => $recipient->name ?? 'N/A',
            'email' => $recipient->email ?? 'N/A',
        ];
    })->values();
@endphp

<link href="{{ asset('admin_assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">

<style>
    .bulk-email-recipient-select-wrap .select2-container {
        width: 100% !important;
    }

    .bulk-email-recipient-select-wrap .select2-container--default .select2-selection--multiple {
        min-height: 42px;
        border: 1px solid #e8ebf3;
        border-radius: 6px;
        padding: 4px 8px;
    }

    .bulk-email-recipient-select-wrap .select2-container--default.select2-container--focus .select2-selection--multiple {
        border-color: var(--primary-bg-color, #6259ca);
    }

    .bulk-email-recipient-select-wrap .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: rgba(98, 89, 202, 0.12);
        border: 1px solid rgba(98, 89, 202, 0.2);
        color: #1a1a2e;
        font-size: 12px;
        padding: 2px 8px;
    }

    .bulk-email-recipient-select-wrap .select2-container--default .select2-search--inline .select2-search__field {
        margin-top: 2px;
    }
</style>

<div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-labelledby="{{ $modalId }}Label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="{{ $modalId }}Label">{{ $modalTitle ?? 'Compose Email' }}</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted tx-13 mb-3">{{ $modalDescription ?? 'Select recipients, then compose and send your email.' }}</p>

                <div class="mb-3">
                    <label class="form-label" for="{{ $prefix }}-email-subject">Subject</label>
                    <input type="text" class="form-control" id="{{ $prefix }}-email-subject" placeholder="Enter email subject">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="{{ $prefix }}-email-message">Message</label>
                    <textarea class="form-control" id="{{ $prefix }}-email-message" rows="8" placeholder="Write your message here..."></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="{{ $prefix }}-email-attachments">Attachments</label>
                    <input type="file" class="form-control" id="{{ $prefix }}-email-attachments" multiple
                        accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.jpg,.jpeg,.png,.gif,.webp,.zip">
                    <small class="text-muted d-block mt-1">Optional. Up to 5 files, 10MB each (PDF, Office docs, images, ZIP).</small>
                    <ul class="list-unstyled mb-0 mt-2 tx-12 text-muted" id="{{ $prefix }}-email-attachment-list"></ul>
                </div>

                <div class="mb-0">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <label class="form-label mb-0" for="{{ $prefix }}-email-recipient-select">
                            Recipients <span class="text-muted tx-12" id="{{ $prefix }}-email-recipient-count"></span>
                        </label>
                        <div class="btn-group btn-group-sm">
                            <button type="button" class="btn btn-outline-primary {{ $prefix }}-email-select-all"
                                @disabled($recipientOptions->isEmpty())>Select All</button>
                            <button type="button" class="btn btn-outline-secondary {{ $prefix }}-email-deselect-all">Clear All</button>
                        </div>
                    </div>
                    <div class="bulk-email-recipient-select-wrap">
                        <select class="form-control bulk-email-recipient-select2" id="{{ $prefix }}-email-recipient-select"
                            multiple data-placeholder="Search and select {{ $recipientPlural }}..."
                            @disabled($recipientOptions->isEmpty())>
                            @foreach ($recipientOptions as $recipient)
                                <option value="{{ $recipient['id'] }}">
                                    {{ $recipient['name'] }} ({{ $recipient['email'] }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <small class="text-muted d-block mt-2">Search and select {{ $recipientPlural }}. Selected names appear as tags above.</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="{{ $prefix }}-email-send-btn" disabled>
                    <i class="fe fe-send me-1"></i> Send Email
                </button>
            </div>
        </div>
    </div>
</div>

<script type="application/json" id="{{ $prefix }}-email-recipients-data">@json($recipientOptions)</script>
