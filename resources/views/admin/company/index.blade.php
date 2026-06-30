<?php $page = 'companysettings/edit/update'; ?>
@extends('admin.layout.app')

@section('page_title', 'Company Settings')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Company Settings</li>
@endsection

@section('admin_content')

@php
    $defaultLogo = \App\Models\CompanySettings::mediaUrl($settings, 'company_logo');
    $defaultLogoSmall = \App\Models\CompanySettings::mediaUrl($settings, 'company_logo_small');
    $defaultFavicon = \App\Models\CompanySettings::mediaUrl($settings, 'company_favicon');
    $fallbackImage = asset('assets/img/logoscroll.png');
@endphp

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

    .form-section-spacer {
        margin-bottom: 1.75rem;
    }

    .brand-image-upload {
        position: relative;
        display: inline-block;
        width: 100%;
        margin: 0 auto;
    }

    .brand-image-upload .brand-preview-img {
        width: 100%;
        object-fit: contain;
        border-radius: 8px;
        border: 1px solid #e8ebf3;
        background: #f8f9fc;
        display: block;
    }

    .brand-image-upload.logo-upload .brand-preview-img {
        height: 120px;
        padding: 12px;
    }

    .brand-image-upload.logo-small-upload .brand-preview-img {
        height: 80px;
        padding: 10px;
    }

    .brand-image-upload.favicon-upload .brand-preview-img {
        width: 72px;
        height: 72px;
        padding: 8px;
        margin: 0 auto;
    }

    .brand-image-upload .brand-image-edit {
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

    .brand-image-upload.favicon-upload .brand-image-edit {
        right: calc(50% - 44px);
    }

    .brand-image-upload .brand-image-edit:hover {
        color: var(--primary-bg-color, #6259ca);
    }

    .brand-upload-card {
        border: 1px solid #e8ebf3;
        border-radius: 8px;
        padding: 1rem;
        background: #fff;
        height: 100%;
    }

    .brand-upload-card .brand-upload-title {
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 0.75rem;
        color: #1f2937;
    }
</style>

<div class="row row-sm">
    <div class="col-lg-4">
        <div class="card mg-b-20">
            <div class="card-body text-center">
                <div class="brand-image-upload logo-upload mb-3">
                    <img alt="Company logo preview"
                        id="preview-company-logo"
                        class="brand-preview-img"
                        src="{{ $defaultLogo }}"
                        onerror="this.onerror=null;this.src='{{ $fallbackImage }}';">
                    <label for="company_logo" class="fas fa-camera brand-image-edit mb-0" title="Upload company logo"></label>
                </div>
                <h5 class="main-profile-name mb-1" id="preview-company-name">{{ $settings->company_name ?? 'Company Name' }}</h5>
                <p class="main-profile-name-text text-muted mb-2" id="preview-company-website">{{ $settings->company_website ?? 'Website' }}</p>
                <p class="form-field-hint mb-0" id="company-logo-file-name">Main logo — PNG or JPG recommended</p>
            </div>
        </div>

        <div class="card mg-b-20">
            <div class="card-body">
                <div class="main-content-label tx-13 mg-b-25">Company Preview</div>
                <div class="main-profile-contact-list">
                    <div class="media">
                        <div class="media-icon bg-primary-transparent text-primary">
                            <i class="fe fe-info"></i>
                        </div>
                        <div class="media-body">
                            <span>About</span>
                            <div id="preview-about">{{ $settings->company_about ? Str::limit($settings->company_about, 80) : 'Not set yet' }}</div>
                        </div>
                    </div>
                    <div class="media">
                        <div class="media-icon bg-success-transparent text-success">
                            <i class="fe fe-phone"></i>
                        </div>
                        <div class="media-body">
                            <span>Contact</span>
                            <div id="preview-contact">{{ $settings->contact_number ?? 'Not set yet' }}</div>
                        </div>
                    </div>
                    <div class="media mb-0">
                        <div class="media-icon bg-info-transparent text-info">
                            <i class="fe fe-mail"></i>
                        </div>
                        <div class="media-body">
                            <span>Email</span>
                            <div id="preview-email">{{ $settings->company_email ?? 'Not set yet' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form class="form-horizontal" action="{{ url('company/update') }}" method="POST" id="company-settings-form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $settings->id }}">
                    <input type="file" name="company_logo" id="company_logo" class="d-none" accept="image/jpeg,image/png,image/jpg,image/webp,image/x-icon">
                    <input type="file" name="company_logo_small" id="company_logo_small" class="d-none" accept="image/jpeg,image/png,image/jpg,image/webp">
                    <input type="file" name="company_favicon" id="company_favicon" class="d-none" accept="image/jpeg,image/png,image/jpg,image/webp,image/x-icon,image/vnd.microsoft.icon">

                    <div class="mb-4 main-content-label">Company Information</div>

                    <div class="form-group form-section-spacer">
                        <label class="form-field-label" for="company_name">Company Name</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fe fe-briefcase"></i></span>
                            <input type="text" class="form-control" name="company_name" id="company_name"
                                placeholder="Company name" value="{{ $settings->company_name }}">
                        </div>
                    </div>

                    <div class="row g-3 form-section-spacer">
                        <div class="col-md-6">
                            <label class="form-field-label" for="company_website">Company Website</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fe fe-globe"></i></span>
                                <input type="url" class="form-control" name="company_website" id="company_website"
                                    placeholder="https://example.com" value="{{ $settings->company_website }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-field-label" for="contact_number">Contact Number</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fe fe-phone"></i></span>
                                <input type="text" class="form-control" name="contact_number" id="contact_number"
                                    placeholder="Phone number" value="{{ $settings->contact_number }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group form-section-spacer">
                        <label class="form-field-label" for="company_email">Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fe fe-mail"></i></span>
                            <input type="email" class="form-control" name="company_email" id="company_email"
                                placeholder="Email address" value="{{ $settings->company_email }}">
                        </div>
                    </div>

                    <div class="form-group form-section-spacer">
                        <label class="form-field-label" for="company_footer_text">Footer Text</label>
                        <div class="input-group">
                            <span class="input-group-text align-items-start pt-2"><i class="fe fe-align-left"></i></span>
                            <textarea class="form-control" name="company_footer_text" id="company_footer_text" rows="2"
                                placeholder="Footer text">{{ $settings->company_footer_text }}</textarea>
                        </div>
                    </div>

                    <div class="form-group form-section-spacer">
                        <label class="form-field-label" for="company_about">About Company</label>
                        <div class="input-group">
                            <span class="input-group-text align-items-start pt-2"><i class="fe fe-file-text"></i></span>
                            <textarea class="form-control" name="company_about" id="company_about" rows="4"
                                placeholder="About company">{{ $settings->company_about }}</textarea>
                        </div>
                    </div>

                    <div class="mb-4 main-content-label">Brand Images</div>

                    <div class="row g-3 form-section-spacer">
                        <div class="col-md-4">
                            <div class="brand-upload-card text-center">
                                <div class="brand-upload-title">Company Logo</div>
                                <div class="brand-image-upload logo-upload">
                                    <img alt="Company logo"
                                        id="brand-preview-logo"
                                        class="brand-preview-img"
                                        src="{{ $defaultLogo }}"
                                        onerror="this.onerror=null;this.src='{{ $fallbackImage }}';">
                                    <label for="company_logo" class="fas fa-camera brand-image-edit mb-0" title="Upload company logo"></label>
                                </div>
                                <p class="form-field-hint mb-0 mt-2" id="brand-logo-file-name">Recommended 300×100px</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="brand-upload-card text-center">
                                <div class="brand-upload-title">Small Logo</div>
                                <div class="brand-image-upload logo-small-upload">
                                    <img alt="Small logo"
                                        id="brand-preview-logo-small"
                                        class="brand-preview-img"
                                        src="{{ $defaultLogoSmall }}"
                                        onerror="this.onerror=null;this.src='{{ $fallbackImage }}';">
                                    <label for="company_logo_small" class="fas fa-camera brand-image-edit mb-0" title="Upload small logo"></label>
                                </div>
                                <p class="form-field-hint mb-0 mt-2" id="brand-logo-small-file-name">For sidebar & mobile</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="brand-upload-card text-center">
                                <div class="brand-upload-title">Favicon</div>
                                <div class="brand-image-upload favicon-upload">
                                    <img alt="Favicon"
                                        id="brand-preview-favicon"
                                        class="brand-preview-img"
                                        src="{{ $defaultFavicon }}"
                                        onerror="this.onerror=null;this.src='{{ $fallbackImage }}';">
                                    <label for="company_favicon" class="fas fa-camera brand-image-edit mb-0" title="Upload favicon"></label>
                                </div>
                                <p class="form-field-hint mb-0 mt-2" id="brand-favicon-file-name">32×32 or 64×64px</p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer d-flex justify-content-between">
                <a href="{{ route('admin.home') }}" class="btn btn-outline-secondary">Cancel</a>
                <button type="submit" form="company-settings-form" class="btn btn-primary waves-effect waves-light">
                    <i class="fe fe-save me-1"></i> Update Settings
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
jQuery(document).ready(function ($) {
    const fallbackImage = @json($fallbackImage);

    const uploadFields = [
        {
            input: '#company_logo',
            previews: ['#preview-company-logo', '#brand-preview-logo'],
            fileName: ['#company-logo-file-name', '#brand-logo-file-name'],
            defaultHint: ['Main logo — PNG or JPG recommended', 'Recommended 300×100px']
        },
        {
            input: '#company_logo_small',
            previews: ['#brand-preview-logo-small'],
            fileName: ['#brand-logo-small-file-name'],
            defaultHint: ['For sidebar & mobile']
        },
        {
            input: '#company_favicon',
            previews: ['#brand-preview-favicon'],
            fileName: ['#brand-favicon-file-name'],
            defaultHint: ['32×32 or 64×64px']
        }
    ];

    function truncateText(text, limit) {
        if (!text) {
            return 'Not set yet';
        }
        return text.length > limit ? text.substring(0, limit) + '...' : text;
    }

    function updatePreview() {
        const name = $('#company_name').val().trim();
        const website = $('#company_website').val().trim();
        const about = $('#company_about').val().trim();
        const contact = $('#contact_number').val().trim();
        const email = $('#company_email').val().trim();

        $('#preview-company-name').text(name || 'Company Name');
        $('#preview-company-website').text(website || 'Website');
        $('#preview-about').text(truncateText(about, 80));
        $('#preview-contact').text(contact || 'Not set yet');
        $('#preview-email').text(email || 'Not set yet');
    }

    function handleImageFile(field, file) {
        if (!file || !file.type.startsWith('image/')) {
            return;
        }

        if (file.size > 4 * 1024 * 1024) {
            alert('Image must not exceed 4MB.');
            $(field.input).val('');
            return;
        }

        field.fileName.forEach(function (selector, index) {
            $(selector).text(file.name);
        });

        const reader = new FileReader();
        reader.onload = function (event) {
            field.previews.forEach(function (selector) {
                $(selector).attr('src', event.target.result);
            });
        };
        reader.readAsDataURL(file);
    }

    uploadFields.forEach(function (field) {
        $(field.input).on('change', function () {
            handleImageFile(field, this.files[0]);
        });

        field.previews.forEach(function (selector) {
            $(selector).on('error', function () {
                if (this.src !== fallbackImage) {
                    this.src = fallbackImage;
                }
            });
        });
    });

    $('#company_name, #company_website, #company_about, #contact_number, #company_email').on('input change', updatePreview);
    updatePreview();
});
</script>
@endpush
