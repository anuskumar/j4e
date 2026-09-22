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

    .venue-map-field {
        border: 1px solid #e8ebf3;
        border-radius: 12px;
        background: #fafbfd;
        padding: 14px;
        height: 100%;
    }

    .venue-map-field__top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 10px;
    }

    .venue-map-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border-radius: 999px;
        padding: 4px 10px;
        font-size: 11px;
        font-weight: 700;
        line-height: 1.2;
        white-space: nowrap;
    }

    .venue-map-status.is-ready {
        background: #ecfdf5;
        color: #047857;
        border: 1px solid #a7f3d0;
    }

    .venue-map-status.is-missing {
        background: #fff7ed;
        color: #c2410c;
        border: 1px solid #fed7aa;
    }

    .venue-map-preview-wrap {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .venue-map-preview {
        width: 88px;
        height: 66px;
        border-radius: 8px;
        object-fit: cover;
        border: 1px solid #e8ebf3;
        background: #fff;
        flex-shrink: 0;
    }

    .venue-map-preview.is-empty {
        display: flex;
        align-items: center;
        justify-content: center;
        color: #9ca3af;
        font-size: 20px;
        background: #f3f4f6;
    }

    .venue-map-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        align-items: center;
    }

    .venue-map-actions .btn {
        font-size: 12px;
        font-weight: 600;
    }
</style>
