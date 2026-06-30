<style>
    .form-field-label {
        font-weight: 600;
        margin-bottom: 0.35rem;
    }

    .form-field-hint {
        font-size: 12px;
        color: #6c757d;
        margin-top: 0.35rem;
    }

    .input-group-text {
        background: #f8f9fc;
        border-color: #e8ebf3;
        min-width: 42px;
        justify-content: center;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--primary-bg-color, #6259ca);
        box-shadow: 0 0 0 0.2rem rgba(98, 89, 202, 0.15);
    }

    .form-control[readonly],
    .form-control:disabled {
        background-color: #f8f9fc;
        cursor: default;
    }

    .event-image-upload {
        position: relative;
        display: inline-block;
        width: 100%;
        max-width: 220px;
        margin: 0 auto;
    }

    .event-image-upload.readonly .event-image-upload-edit {
        display: none;
    }

    .event-image-upload .event-preview-img {
        width: 100%;
        height: 160px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #e8ebf3;
        background: #f8f9fc;
        display: block;
    }

    .event-image-upload .event-image-edit {
        position: absolute;
        bottom: 8px;
        right: 8px;
        width: 32px;
        height: 32px;
        line-height: 32px;
        border-radius: 50%;
        background: #fff;
        border: 1px solid #e8ebf3;
        text-align: center;
        cursor: pointer;
        color: #6c757d;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.08);
        margin: 0;
    }

    .event-image-upload .event-image-edit:hover {
        color: var(--primary-bg-color, #6259ca);
    }

    .select2-container {
        width: 100% !important;
    }

    .select2-container--default .select2-selection--single,
    .select2-container--default .select2-selection--multiple {
        border-color: #e8ebf3 !important;
        min-height: 38px;
    }

    .select2-container--default.select2-container--focus .select2-selection--single,
    .select2-container--default.select2-container--focus .select2-selection--multiple {
        border-color: var(--primary-bg-color, #6259ca) !important;
    }

    .form-section-spacer {
        margin-bottom: 1.75rem;
    }

    .select2-results__option.create-new-option {
        color: var(--primary-bg-color, #6259ca);
        font-weight: 600;
        border-top: 1px solid #e8ebf3;
    }

    .select2-results__option.create-new-option:before {
        content: '+ ';
    }

    .readonly-badge-list {
        display: flex;
        flex-wrap: wrap;
        gap: 0.35rem;
    }

    .readonly-badge-list .badge {
        font-weight: 500;
        font-size: 12px;
    }
</style>
