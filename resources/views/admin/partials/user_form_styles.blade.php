<style>
    .profile-upload-wrap { position: relative; display: inline-block; }
    .profile-upload-wrap .profile-edit { cursor: pointer; }
    .profile-file-name { font-size: 12px; color: #6c757d; }
    .form-field-label { font-weight: 600; margin-bottom: 0.35rem; }
    .form-field-hint { font-size: 12px; color: #6c757d; margin-top: 0.35rem; }
    .input-group-text { background: #f8f9fc; border-color: #e8ebf3; min-width: 42px; justify-content: center; }
    .form-control:focus, .form-select:focus {
        border-color: var(--primary-bg-color, #6259ca);
        box-shadow: 0 0 0 0.2rem rgba(98, 89, 202, 0.15);
    }
    .view-field { background-color: #f8f9fc; border-color: #e8ebf3; color: #1f2937; }
    .password-strength { height: 4px; border-radius: 4px; background: #e9ecef; margin-top: 0.5rem; overflow: hidden; }
    .password-strength span { display: block; height: 100%; width: 0; transition: width 0.2s ease, background 0.2s ease; }
    .form-section-spacer { margin-bottom: 1.75rem; }
    .event-image-upload {
        position: relative;
        display: inline-block;
        width: 100%;
        max-width: 220px;
        margin: 0 auto;
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
    .preview-icon-wrap .preview-icon {
        width: 80px;
        height: 80px;
        border-radius: 12px;
        font-size: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
</style>
