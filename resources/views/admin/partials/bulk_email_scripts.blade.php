@php
    $prefix = $emailPrefix ?? 'bulk';
    $modalId = $prefix . 'EmailModal';
    $recipientIdsField = $recipientIdsField ?? 'recipient_ids';
@endphp

<script src="{{ asset('admin_assets/plugins/select2/js/select2.min.js') }}"></script>
<script>
jQuery(document).ready(function ($) {
    const emailPrefix = @json($prefix);
    const recipientIdsField = @json($recipientIdsField);
    const emailModalEl = document.getElementById(@json($modalId));
    const emailModal = emailModalEl ? bootstrap.Modal.getOrCreateInstance(emailModalEl) : null;
    const openBtn = $('#' + emailPrefix + '-send-email-btn');
    const messageField = $('#' + emailPrefix + '-email-message');
    const attachmentInput = $('#' + emailPrefix + '-email-attachments');
    const attachmentList = $('#' + emailPrefix + '-email-attachment-list');
    const recipientSelect = $('#' + emailPrefix + '-email-recipient-select');
    const recipientsDataEl = document.getElementById(emailPrefix + '-email-recipients-data');
    const recipientsPool = recipientsDataEl ? JSON.parse(recipientsDataEl.textContent || '[]') : [];

    function escapeHtml(value) {
        return $('<div>').text(value ?? '').html();
    }

    function getSelectedRecipientIds() {
        return (recipientSelect.val() || []).map(String);
    }

    function formatFileSize(bytes) {
        if (bytes < 1024) {
            return bytes + ' B';
        }
        if (bytes < 1048576) {
            return (bytes / 1024).toFixed(1) + ' KB';
        }
        return (bytes / 1048576).toFixed(1) + ' MB';
    }

    function initRecipientSelect2() {
        if (!recipientSelect.length || typeof $.fn.select2 !== 'function') {
            return;
        }

        if (recipientSelect.hasClass('select2-hidden-accessible')) {
            recipientSelect.select2('destroy');
        }

        recipientSelect.select2({
            width: '100%',
            placeholder: recipientSelect.data('placeholder') || 'Search and select recipients...',
            allowClear: true,
            closeOnSelect: false,
            dropdownParent: $(emailModalEl)
        });
    }

    function updateAttachmentList() {
        attachmentList.empty();
        const files = attachmentInput[0]?.files || [];

        if (!files.length) {
            return;
        }

        Array.from(files).forEach(function (file) {
            attachmentList.append(
                '<li><i class="fe fe-paperclip me-1"></i>' + escapeHtml(file.name) + ' <span class="text-muted">(' + formatFileSize(file.size) + ')</span></li>'
            );
        });
    }

    function updateRecipientCount() {
        const total = recipientsPool.length;
        const selected = getSelectedRecipientIds().length;
        $('#' + emailPrefix + '-email-recipient-count').text('(' + selected + ' of ' + total + ' selected)');
        $('#' + emailPrefix + '-email-send-btn').prop('disabled', selected === 0);
    }

    function clearRecipients() {
        recipientSelect.val(null).trigger('change');
        updateRecipientCount();
    }

    function selectAllRecipients() {
        recipientSelect.val(recipientsPool.map(function (recipient) {
            return String(recipient.id);
        })).trigger('change');
        updateRecipientCount();
    }

    initRecipientSelect2();

    openBtn.on('click', function () {
        if (!emailModal) {
            return;
        }

        $('#' + emailPrefix + '-email-subject').val('');
        attachmentInput.val('');
        attachmentList.empty();

        if (messageField.next('.note-editor').length) {
            messageField.summernote('reset');
        } else {
            messageField.val('');
        }

        clearRecipients();
        emailModal.show();
    });

    if (emailModalEl) {
        emailModalEl.addEventListener('shown.bs.modal', function () {
            initRecipientSelect2();
            updateRecipientCount();
        });
    }

    recipientSelect.on('change', updateRecipientCount);

    attachmentInput.on('change', function () {
        if (this.files.length > 5) {
            swal({
                title: 'Too many files',
                text: 'You can attach up to 5 files only.',
                icon: 'warning',
                button: 'OK'
            });
            this.value = '';
            attachmentList.empty();
            return;
        }
        updateAttachmentList();
    });

    $('.' + emailPrefix + '-email-select-all').on('click', function () {
        selectAllRecipients();
    });

    $('.' + emailPrefix + '-email-deselect-all').on('click', function () {
        clearRecipients();
    });

    if (messageField.length && typeof $.fn.summernote === 'function') {
        messageField.summernote({
            height: 180,
            placeholder: 'Write your message here...',
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link']],
                ['view', ['codeview']]
            ]
        });
    }

    $('#' + emailPrefix + '-email-send-btn').on('click', function () {
        const subject = $('#' + emailPrefix + '-email-subject').val().trim();
        const message = messageField.next('.note-editor').length
            ? messageField.summernote('code')
            : messageField.val();
        const recipientIds = getSelectedRecipientIds();

        if (!subject) {
            swal({ title: 'Subject required', text: 'Please enter an email subject.', icon: 'warning', button: 'OK' });
            return;
        }

        if (!message || message.replace(/<[^>]*>/g, '').trim() === '') {
            swal({ title: 'Message required', text: 'Please enter an email message.', icon: 'warning', button: 'OK' });
            return;
        }

        if (recipientIds.length === 0) {
            swal({ title: 'No recipients', text: 'Select at least one recipient to send email.', icon: 'warning', button: 'OK' });
            return;
        }

        const sendBtn = $(this);
        const formData = new FormData();
        formData.append('subject', subject);
        formData.append('message', message);
        formData.append('_token', '{{ csrf_token() }}');
        recipientIds.forEach(function (id) {
            formData.append(recipientIdsField + '[]', id);
        });

        const files = attachmentInput[0]?.files || [];
        Array.from(files).forEach(function (file) {
            formData.append('attachments[]', file);
        });

        sendBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Sending...');

        $.ajax({
            url: @json($sendRoute),
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                sendBtn.prop('disabled', false).html('<i class="fe fe-send me-1"></i> Send Email');
                if (response.success) {
                    if (emailModal) {
                        emailModal.hide();
                    }
                    swal({
                        title: 'Success!',
                        text: response.message,
                        icon: 'success',
                        button: 'OK',
                        timer: 3000
                    });
                } else {
                    swal({
                        title: 'Error!',
                        text: response.message || 'Failed to send email.',
                        icon: 'error',
                        button: 'OK'
                    });
                }
            },
            error: function (xhr) {
                sendBtn.prop('disabled', false).html('<i class="fe fe-send me-1"></i> Send Email');
                let errorMsg = 'Something went wrong. Please try again.';
                if (xhr.responseJSON) {
                    if (xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    } else if (xhr.responseJSON.errors) {
                        errorMsg = Object.values(xhr.responseJSON.errors).flat().join('\n');
                    }
                }
                swal({
                    title: 'Error!',
                    text: errorMsg,
                    icon: 'error',
                    button: 'OK'
                });
            }
        });
    });

    updateRecipientCount();
});
</script>
