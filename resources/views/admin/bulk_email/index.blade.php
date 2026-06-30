<?php $page = 'bulk-email-logs'; ?>
@extends('admin.layout.app')

@section('page_title', 'Sent Emails')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Sent Emails</li>
@endsection

@section('admin_content')

<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <h4 class="card-title mg-b-10">Sent Emails</h4>
                        <p class="text-muted tx-12 mb-0">History of bulk emails sent to customers and resellers.</p>
                    </div>
                    <span class="badge bg-primary-transparent tx-13">{{ $logs->total() }} {{ Str::plural('record', $logs->total()) }}</span>
                </div>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('admin.bulk-email.index') }}" class="mb-4">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label" for="type">Recipient Type</label>
                            <select name="type" id="type" class="form-control form-select">
                                <option value="all" @selected(($filters['type'] ?? 'all') === 'all')>All</option>
                                <option value="customer" @selected(($filters['type'] ?? '') === 'customer')>Customer</option>
                                <option value="reseller" @selected(($filters['type'] ?? '') === 'reseller')>Reseller</option>
                            </select>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label" for="search">Search</label>
                            <input type="text" name="search" id="search" class="form-control"
                                value="{{ $filters['search'] ?? '' }}"
                                placeholder="Search by subject or message">
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fe fe-filter me-1"></i> Apply
                                </button>
                                <a href="{{ route('admin.bulk-email.index') }}" class="btn btn-outline-secondary">Clear</a>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered text-nowrap mb-0">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Type</th>
                                <th>Subject</th>
                                <th>Sent By</th>
                                <th>Recipients</th>
                                <th>Attachments</th>
                                <th>Sent</th>
                                <th>Failed</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($logs as $log)
                                <tr>
                                    <td>
                                        {{ $log->created_at->format('d M Y') }}
                                        <span class="d-block text-muted tx-12">{{ $log->created_at->format('h:i A') }}</span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $log->statusBadgeClass() }}">
                                            {{ $log->statusLabel() }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $log->recipient_type === 'customer' ? 'bg-info-transparent' : 'bg-warning-transparent' }}">
                                            {{ $log->recipientTypeLabel() }}
                                        </span>
                                    </td>
                                    <td>{{ Str::limit($log->subject, 50) }}</td>
                                    <td>{{ $log->sender?->name ?? 'N/A' }}</td>
                                    <td>{{ $log->recipient_count }}</td>
                                    <td>
                                        @if (!empty($log->attachments))
                                            <div class="d-flex flex-column gap-1">
                                                @foreach ($log->attachments as $index => $attachment)
                                                    <a href="{{ route('admin.bulk-email.attachment', [$log->id, $index]) }}"
                                                        class="tx-12 text-primary d-inline-flex align-items-center"
                                                        title="Download {{ $attachment['name'] ?? 'attachment' }}">
                                                        <i class="fe fe-paperclip me-1"></i>
                                                        {{ Str::limit($attachment['name'] ?? 'Attachment', 28) }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td><span class="text-success">{{ $log->sent_count }}</span></td>
                                    <td>
                                        @if ($log->failed_count > 0)
                                            <span class="text-danger">{{ $log->failed_count }}</span>
                                        @else
                                            <span class="text-muted">0</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.bulk-email.show', $log->id) }}" class="btn btn-sm btn-info-light" title="View">
                                            <i class="far fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center text-muted py-4">No sent emails found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($logs->hasPages())
                    <div class="mt-3">
                        {{ $logs->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
