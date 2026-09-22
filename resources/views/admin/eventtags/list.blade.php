<?php $page = 'eventtags/list'; ?>
@extends('admin.layout.app')

@section('page_title', 'Event Tags')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ url('events/list') }}">Events</a></li>
    <li class="breadcrumb-item active" aria-current="page">Event Tags</li>
@endsection

@section('admin_content')

<style>
    .event-tag-order-hint {
        font-size: 12px;
        color: #6c757d;
    }

    .drag-handle {
        cursor: grab;
        color: #9ca3af;
        font-size: 16px;
        line-height: 1;
        user-select: none;
    }

    .drag-handle:active {
        cursor: grabbing;
    }

    tr.event-tag-row.dragging {
        opacity: 0.55;
        background: #f8f9fc;
    }

    tr.event-tag-row.drag-over {
        box-shadow: inset 0 2px 0 0 var(--primary-bg-color, #6259ca);
    }

    .sort-order-badge {
        min-width: 28px;
        display: inline-block;
        text-align: center;
    }

    .tag-thumb {
        width: 48px;
        height: 48px;
        object-fit: cover;
        border-radius: 6px;
        border: 1px solid #e8ebf3;
    }
</style>

<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title mg-b-10">Event Tags</h4>
                        <p class="text-muted tx-12 mb-0">
                            Manage event tags and tag images.
                            <span class="event-tag-order-hint">Drag rows to change display order.</span>
                        </p>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-primary-transparent tx-13">{{ count($tags) }} {{ Str::plural('tag', count($tags)) }}</span>
                        <a href="{{ url('eventtags/create') }}" class="btn btn-primary btn-sm">
                            <i class="fe fe-plus me-1"></i> Create Event Tag
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div id="event-tag-reorder-status" class="alert d-none mb-3" role="alert"></div>
                <div class="table-responsive">
                    <table class="table table-bordered text-nowrap mb-0" id="event-tag-table">
                        <thead>
                            <tr>
                                <th style="width: 48px;"></th>
                                <th style="width: 70px;">Order</th>
                                <th>Tag Name</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody id="event-tag-sortable">
                            @forelse ($tags as $index => $val)
                                <tr class="event-tag-row" draggable="true" data-id="{{ $val->id }}">
                                    <td class="text-center align-middle">
                                        <span class="drag-handle" title="Drag to reorder">☰</span>
                                    </td>
                                    <td class="align-middle">
                                        <span class="badge bg-light text-dark sort-order-badge">{{ $val->sort_order ?? ($index + 1) }}</span>
                                    </td>
                                    <td class="align-middle"><span class="font-weight-semibold">{{ $val->tag_name }}</span></td>
                                    <td class="align-middle">
                                        @if ($val->tag_image)
                                            <img alt="{{ $val->tag_name }}" class="tag-thumb"
                                                src="{{ asset('storage/uploads/event_tag_images/' . $val->tag_image) }}"
                                                onerror="this.src='{{ asset('assets/img/events/event-01.jpg') }}'">
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        @if ($val->is_active == 1)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-warning">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="text-end align-middle">
                                        <div class="table-action d-flex justify-content-end gap-1">
                                            <a href="{{ url('eventtags/view', $val->id) }}" class="btn btn-sm btn-info-light" title="View">
                                                <i class="far fa-eye"></i>
                                            </a>
                                            <a href="{{ url('eventtags/edit', $val->id) }}" class="btn btn-sm btn-success-light" title="Edit">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            <form action="{{ url('eventtags/destroy', $val->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this event tag?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger-light" title="Delete">
                                                    <i class="far fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">No event tags found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
jQuery(document).ready(function ($) {
    const $tbody = $('#event-tag-sortable');
    const $status = $('#event-tag-reorder-status');
    const csrfToken = $('meta[name="csrf-token"]').attr('content');
    const reorderUrl = @json(url('eventtags/reorder'));
    let draggedRow = null;
    let saveTimer = null;

    function showStatus(message, type) {
        $status
            .removeClass('d-none alert-success alert-danger alert-info')
            .addClass('alert-' + type)
            .text(message);
    }

    function renumberBadges() {
        $tbody.find('tr.event-tag-row').each(function (index) {
            $(this).find('.sort-order-badge').text(index + 1);
        });
    }

    function persistOrder() {
        const order = $tbody.find('tr.event-tag-row').map(function () {
            return $(this).data('id');
        }).get();

        if (!order.length) {
            return;
        }

        showStatus('Saving order...', 'info');

        $.ajax({
            url: reorderUrl,
            method: 'POST',
            data: {
                _token: csrfToken,
                order: order
            },
            headers: {
                'Accept': 'application/json'
            }
        }).done(function (response) {
            showStatus(response.message || 'Order saved.', 'success');
            setTimeout(function () {
                $status.addClass('d-none');
            }, 2000);
        }).fail(function (xhr) {
            const message = (xhr.responseJSON && xhr.responseJSON.message)
                ? xhr.responseJSON.message
                : 'Unable to save order. Please try again.';
            showStatus(message, 'danger');
        });
    }

    function schedulePersist() {
        clearTimeout(saveTimer);
        saveTimer = setTimeout(persistOrder, 250);
    }

    $tbody.on('dragstart', 'tr.event-tag-row', function (event) {
        draggedRow = this;
        $(this).addClass('dragging');
        if (event.originalEvent && event.originalEvent.dataTransfer) {
            event.originalEvent.dataTransfer.effectAllowed = 'move';
            event.originalEvent.dataTransfer.setData('text/plain', $(this).data('id'));
        }
    });

    $tbody.on('dragend', 'tr.event-tag-row', function () {
        $(this).removeClass('dragging');
        $tbody.find('tr.event-tag-row').removeClass('drag-over');
        draggedRow = null;
        renumberBadges();
        schedulePersist();
    });

    $tbody.on('dragover', 'tr.event-tag-row', function (event) {
        event.preventDefault();
        if (!draggedRow || draggedRow === this) {
            return;
        }

        const $target = $(this);
        $tbody.find('tr.event-tag-row').removeClass('drag-over');
        $target.addClass('drag-over');

        const bounding = this.getBoundingClientRect();
        const offset = event.originalEvent.clientY - bounding.top;
        if (offset > bounding.height / 2) {
            $target.after(draggedRow);
        } else {
            $target.before(draggedRow);
        }
    });

    $tbody.on('drop', 'tr.event-tag-row', function (event) {
        event.preventDefault();
        $tbody.find('tr.event-tag-row').removeClass('drag-over');
    });

    $tbody.on('mousedown', 'a, button, input, form', function (event) {
        event.stopPropagation();
    });
});
</script>
@endpush
