@php
    $prefix = $emailPrefix ?? 'bulk';
    $modalId = $prefix . 'EmailModal';
    $recipientLabel = $recipientLabel ?? 'recipient';
    $recipientPlural = Str::plural($recipientLabel);
@endphp

<style>
    .bulk-email-recipients {
        max-height: 260px;
        overflow-y: auto;
        border: 1px solid #e8ebf3;
        border-radius: 6px;
        background: #f8f9fc;
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 0.5rem;
        padding: 0.75rem;
    }

    .bulk-email-recipients .recipient-item {
        display: flex;
        align-items: flex-start;
        gap: 0.5rem;
        padding: 0.55rem 0.6rem;
        border: 1px solid #e8ebf3;
        border-radius: 6px;
        background: #fff;
        cursor: pointer;
        min-width: 0;
    }

    .bulk-email-recipients .recipient-item .form-check-input {
        margin-top: 0.15rem;
        flex-shrink: 0;
    }

    .bulk-email-recipients .recipient-meta {
        min-width: 0;
        flex: 1;
    }

    .bulk-email-recipients .recipient-name {
        font-weight: 600;
        font-size: 12px;
        color: #1a1a2e;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .bulk-email-recipients .recipient-email {
        font-size: 11px;
        color: #6c757d;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    @media (max-width: 767.98px) {
        .bulk-email-recipients {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
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
                <p class="text-muted tx-13 mb-3">{{ $modalDescription ?? 'Send an email to the filtered list. Uncheck anyone you want to exclude.' }}</p>

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
                        <label class="form-label mb-0">Recipients <span class="text-muted tx-12" id="{{ $prefix }}-email-recipient-count"></span></label>
                        <div class="btn-group btn-group-sm">
                            <button type="button" class="btn btn-outline-primary {{ $prefix }}-email-select-all">Select All</button>
                            <button type="button" class="btn btn-outline-secondary {{ $prefix }}-email-deselect-all">Deselect All</button>
                        </div>
                    </div>
                    <div class="bulk-email-recipients" id="{{ $prefix }}-email-recipients">
                        @foreach ($recipients as $recipient)
                            <label class="recipient-item mb-0" for="{{ $prefix }}_recipient_{{ $recipient->id }}">
                                <input class="form-check-input {{ $prefix }}-email-recipient" type="checkbox"
                                    value="{{ $recipient->id }}" id="{{ $prefix }}_recipient_{{ $recipient->id }}" checked>
                                <span class="recipient-meta">
                                    <span class="recipient-name d-block">{{ $recipient->name ?? 'N/A' }}</span>
                                    <span class="recipient-email d-block">{{ $recipient->email ?? 'N/A' }}</span>
                                </span>
                            </label>
                        @endforeach
                    </div>
                    <small class="text-muted d-block mt-2">Uncheck {{ $recipientPlural }} you want to exclude from this email.</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="{{ $prefix }}-email-send-btn">
                    <i class="fe fe-send me-1"></i> Send Email
                </button>
            </div>
        </div>
    </div>
</div>
