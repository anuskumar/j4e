<?php $page = 'events/event_images'; ?>
@extends('admin.layout.app')

@section('page_title', 'Event Images')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ url('events/list') }}">Events</a></li>
    <li class="breadcrumb-item active" aria-current="page">Event Images</li>
@endsection

@section('admin_content')

<style>
    .event-image-card {
        border: 1px solid #e8ebf3;
        border-radius: 8px;
        overflow: hidden;
        transition: box-shadow 0.2s ease;
    }
    .event-image-card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }
    .event-image-card img {
        width: 100%;
        height: 180px;
        object-fit: cover;
        display: block;
    }
    .event-image-card .card-actions {
        padding: 10px 12px;
        background: #fff;
        border-top: 1px solid #e8ebf3;
    }
    .upload-dropzone {
        border: 2px dashed #d5dae6;
        border-radius: 8px;
        padding: 24px;
        text-align: center;
        background: #fafbfc;
        cursor: pointer;
        transition: border-color 0.2s ease, background 0.2s ease;
        position: relative;
        overflow: hidden;
    }
    .upload-dropzone:hover,
    .upload-dropzone.dragover {
        border-color: var(--primary-bg-color, #6259ca);
        background: #f5f3ff;
    }
    .upload-preview-list {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 12px;
    }
    .upload-dropzone input[type="file"] {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
        width: 100%;
        height: 100%;
        z-index: 2;
    }
    .upload-dropzone .dropzone-content {
        position: relative;
        z-index: 1;
        pointer-events: none;
    }
    .upload-preview-item {
        width: 72px;
        height: 72px;
        border-radius: 6px;
        object-fit: cover;
        border: 1px solid #e8ebf3;
    }
</style>

<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <h4 class="card-title mg-b-10">Event Images</h4>
                        <p class="text-muted tx-12 mb-0">
                            Manage gallery images for
                            <span class="font-weight-semibold">{{ $event->event_name ?? 'Event #' . $id }}</span>
                        </p>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-primary-transparent tx-13">{{ count($data) }} {{ Str::plural('image', count($data)) }}</span>
                        <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#uploadImagesModal">
                            <i class="fe fe-upload me-1"></i> Upload Images
                        </button>
                        <a href="{{ url('events/list') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fe fe-arrow-left me-1"></i> Back to Events
                        </a>
                    </div>
                </div>
            </div>
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

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if ($data->isEmpty())
                    <div class="text-center py-5">
                        <div class="avatar avatar-xxl bg-light rounded-circle mx-auto mb-3">
                            <i class="fe fe-image tx-30 text-muted"></i>
                        </div>
                        <h5 class="mb-1">No images uploaded yet</h5>
                        <p class="text-muted mb-3">Upload one or more images to build the event gallery.</p>
                        <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#uploadImagesModal">
                            <i class="fe fe-upload me-1"></i> Upload Images
                        </button>
                    </div>
                @else
                    <div class="row g-3">
                        @foreach ($data as $val)
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                                <div class="event-image-card">
                                    <a href="{{ asset('storage/uploads/events/' . $val->image) }}" target="_blank" rel="noopener">
                                        <img src="{{ asset('storage/uploads/events/' . $val->image) }}"
                                            alt="Event image"
                                            onerror="this.onerror=null;this.src='{{ asset('assets/img/default-event.jpg') }}';">
                                    </a>
                                    <div class="card-actions d-flex justify-content-between align-items-center">
                                        <span class="text-muted tx-12 text-truncate me-2">{{ $val->image }}</span>
                                        <a href="{{ url('events/delete_images/' . $val->id) }}"
                                            class="btn btn-sm btn-danger-light"
                                            title="Delete"
                                            onclick="return confirm('Delete this image?');">
                                            <i class="far fa-trash-alt"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="uploadImagesModal" tabindex="-1" aria-labelledby="uploadImagesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form action="{{ url('events/upload_event_images') }}" method="post" enctype="multipart/form-data" id="upload-images-form">
            @csrf
            <input type="hidden" name="event" value="{{ $id }}">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="uploadImagesModalLabel">Upload Event Images</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="upload-dropzone mb-0" id="upload-dropzone">
                        <input type="file" name="image[]" id="event_images_input" accept="image/jpeg,image/png,image/jpg,image/webp,image/gif" multiple>
                        <div class="dropzone-content">
                            <i class="fe fe-upload tx-24 text-primary d-block mb-2"></i>
                            <span class="d-block fw-semibold">Click to choose images or drag and drop</span>
                            <span class="d-block text-muted tx-12 mt-1">JPG, PNG, WEBP or GIF — max 2MB each</span>
                            <span class="d-block text-muted tx-12 mt-2" id="upload-file-count">No files selected</span>
                        </div>
                    </div>
                    <div class="upload-preview-list" id="upload-preview-list"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fe fe-upload me-1"></i> Upload
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
jQuery(document).ready(function ($) {
    const $form = $('#upload-images-form');
    const $input = $('#event_images_input');
    const $dropzone = $('#upload-dropzone');
    const $previewList = $('#upload-preview-list');
    const $fileCount = $('#upload-file-count');
    const $modal = $('#uploadImagesModal');

    function renderPreviews(files) {
        $previewList.empty();
        const imageFiles = [];
        const rejectedFiles = [];

        Array.from(files || []).forEach(function (file) {
            if (!file.type || !file.type.startsWith('image/')) {
                rejectedFiles.push(file.name);
                return;
            }

            if (file.size > 2 * 1024 * 1024) {
                rejectedFiles.push(file.name + ' (over 2MB)');
                return;
            }

            imageFiles.push(file);
        });

        if (rejectedFiles.length) {
            alert('These files were skipped:\n' + rejectedFiles.join('\n') + '\n\nEach image must be under 2MB.');
        }

        if (!imageFiles.length) {
            $fileCount.text('No files selected');
            $input.val('');
            return;
        }

        $fileCount.text(imageFiles.length + ' file(s) selected');

        imageFiles.forEach(function (file) {
            const reader = new FileReader();
            reader.onload = function (event) {
                $('<img>', {
                    src: event.target.result,
                    class: 'upload-preview-item',
                    alt: file.name,
                    title: file.name
                }).appendTo($previewList);
            };
            reader.readAsDataURL(file);
        });
    }

    function resetUploadForm() {
        $form[0].reset();
        $previewList.empty();
        $fileCount.text('No files selected');
    }

    $input.on('change', function () {
        renderPreviews(this.files);
    });

    $dropzone.on('dragenter dragover', function (e) {
        e.preventDefault();
        $(this).addClass('dragover');
    });

    $dropzone.on('dragleave drop', function () {
        $(this).removeClass('dragover');
    });

    $form.on('submit', function (e) {
        const files = $input[0].files;

        if (!files || !files.length) {
            e.preventDefault();
            alert('Please select at least one image to upload.');
            return;
        }

        for (let i = 0; i < files.length; i++) {
            if (files[i].size > 2 * 1024 * 1024) {
                e.preventDefault();
                alert('Each image must be 2MB or smaller. Please remove larger files and try again.');
                return;
            }
        }
    });

    $modal.on('hidden.bs.modal', resetUploadForm);

    @if ($errors->any())
        const uploadModalEl = document.getElementById('uploadImagesModal');
        if (uploadModalEl && typeof bootstrap !== 'undefined') {
            bootstrap.Modal.getOrCreateInstance(uploadModalEl).show();
        }
    @endif
});
</script>
@endpush
