<?php $page = 'bulk-email-logs'; ?>
@extends('admin.layout.app')

@section('page_title', 'Email Details')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.bulk-email.index') }}">Sent Emails</a></li>
    <li class="breadcrumb-item active" aria-current="page">Details</li>
@endsection

@section('admin_content')

<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <h4 class="card-title mg-b-10">Email Details</h4>
                    <p class="text-muted tx-12 mb-0">Sent on {{ $bulkEmailLog->created_at->format('d M Y, h:i A') }}</p>
                </div>
                <a href="{{ route('admin.bulk-email.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fe fe-arrow-left me-1"></i> Back to List
                </a>
            </div>
            <div class="card-body">
                <div class="row g-4 mb-4">
                    <div class="col-md-3">
                        <label class="form-label text-muted tx-12 text-uppercase">Recipient Type</label>
                        <p class="mb-0">
                            <span class="badge {{ $bulkEmailLog->recipient_type === 'customer' ? 'bg-info-transparent' : 'bg-warning-transparent' }}">
                                {{ $bulkEmailLog->recipientTypeLabel() }}
                            </span>
                        </p>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label text-muted tx-12 text-uppercase">Status</label>
                        <p class="mb-0">
                            <span class="badge {{ $bulkEmailLog->statusBadgeClass() }}">
                                {{ $bulkEmailLog->statusLabel() }}
                            </span>
                        </p>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-muted tx-12 text-uppercase">Sent By</label>
                        <p class="mb-0">{{ $bulkEmailLog->sender?->name ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label text-muted tx-12 text-uppercase">Recipients</label>
                        <p class="mb-0">{{ $bulkEmailLog->recipient_count }}</p>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label text-muted tx-12 text-uppercase">Sent</label>
                        <p class="mb-0 text-success">{{ $bulkEmailLog->sent_count }}</p>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label text-muted tx-12 text-uppercase">Failed</label>
                        <p class="mb-0 {{ $bulkEmailLog->failed_count > 0 ? 'text-danger' : 'text-muted' }}">{{ $bulkEmailLog->failed_count }}</p>
                    </div>
                </div>

                @if ($bulkEmailLog->isInProgress())
                    <div class="alert alert-info mb-4">
                        This bulk email is still being processed. Refresh this page to see updated delivery status.
                    </div>
                @endif

                <div class="mb-4">
                    <label class="form-label text-muted tx-12 text-uppercase">Subject</label>
                    <p class="mb-0 font-weight-semibold">{{ $bulkEmailLog->subject }}</p>
                </div>

                <div class="mb-4">
                    <label class="form-label text-muted tx-12 text-uppercase">Message</label>
                    <div class="border rounded p-3 bg-light">{!! $bulkEmailLog->message !!}</div>
                </div>

                @if (!empty($bulkEmailLog->attachments))
                    <div class="mb-4">
                        <label class="form-label text-muted tx-12 text-uppercase mb-2">Attachments</label>
                        <ul class="list-group list-group-flush border rounded">
                            @foreach ($bulkEmailLog->attachments as $index => $attachment)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>
                                        <i class="fe fe-paperclip me-1"></i>
                                        {{ $attachment['name'] ?? 'Attachment' }}
                                        @if (!empty($attachment['size']))
                                            <span class="text-muted tx-12">({{ number_format($attachment['size'] / 1024, 1) }} KB)</span>
                                        @endif
                                    </span>
                                    <a href="{{ route('admin.bulk-email.attachment', [$bulkEmailLog->id, $index]) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="fe fe-download me-1"></i> Download
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div>
                    <label class="form-label text-muted tx-12 text-uppercase mb-2">Recipient List</label>
                    <div class="table-responsive">
                        <table class="table table-bordered text-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bulkEmailLog->recipients ?? [] as $recipient)
                                    <tr>
                                        <td>{{ $recipient['name'] ?? 'N/A' }}</td>
                                        <td>{{ $recipient['email'] ?? 'N/A' }}</td>
                                        <td>
                                            @if (($recipient['status'] ?? '') === 'sent')
                                                <span class="badge bg-success-transparent">Sent</span>
                                            @elseif (($recipient['status'] ?? '') === 'pending')
                                                <span class="badge bg-secondary-transparent">Pending</span>
                                            @else
                                                <span class="badge bg-danger-transparent">Failed</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
