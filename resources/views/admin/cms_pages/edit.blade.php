<?php $page = 'cms-pages/edit'; ?>
@extends('admin.layout.app')

@section('page_title', 'Edit CMS Page')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.cms-pages.index') }}">CMS Pages</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit</li>
@endsection

@section('admin_content')

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
    .note-editor.note-frame {
        border-radius: 8px;
        border-color: #e8ebf3;
    }
</style>

<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="mb-4 main-content-label">Edit {{ $data->title }}</div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.cms-pages.update') }}" method="POST" id="cms-page-form">
                    @csrf
                    <input type="hidden" name="id" value="{{ $data->id }}">

                    <div class="form-group mb-3">
                        <label class="form-field-label" for="title">Page Title</label>
                        <input type="text" class="form-control" name="title" id="title"
                            value="{{ old('title', $data->title) }}" required>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-field-label">Public URL</label>
                        <input type="text" class="form-control" value="{{ url($data->slug) }}" readonly>
                        <p class="form-field-hint mb-0">Slug is fixed for system pages ({{ $data->slug }}).</p>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-field-label" for="content">Page Content</label>
                        <textarea class="form-control" name="content" id="content" rows="14">{{ old('content', $data->content) }}</textarea>
                        <p class="form-field-hint mb-0">Use the toolbar to format headings, lists, links, and more. This content is shown on the public {{ $data->title }} page.</p>
                    </div>

                    <div class="form-group mb-0">
                        <label class="form-field-label d-block">Status</label>
                        <label class="me-3">
                            <input type="radio" name="is_active" value="1"
                                {{ (string) old('is_active', $data->is_active ? '1' : '0') === '1' ? 'checked' : '' }}>
                            Active
                        </label>
                        <label>
                            <input type="radio" name="is_active" value="0"
                                {{ (string) old('is_active', $data->is_active ? '1' : '0') === '0' ? 'checked' : '' }}>
                            Inactive
                        </label>
                    </div>
                </form>
            </div>
            <div class="card-footer d-flex justify-content-between">
                <a href="{{ route('admin.cms-pages.index') }}" class="btn btn-outline-secondary">Cancel</a>
                <button type="submit" form="cms-page-form" class="btn btn-primary">
                    <i class="fe fe-save me-1"></i> Update Page
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
jQuery(document).ready(function ($) {
    var $content = $('#content');

    if ($content.length && typeof $.fn.summernote === 'function') {
        $content.summernote({
            height: 420,
            placeholder: 'Write page content here...',
            dialogsInBody: true,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
                ['fontname', ['fontname']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'hr']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });

        $('#cms-page-form').on('submit', function () {
            $content.val($content.summernote('code'));
        });
    }
});
</script>
@endpush
