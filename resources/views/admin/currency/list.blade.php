<?php $page = 'currency/list'; ?>
@extends('admin.layout.app')

@section('page_title', 'Currency')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Currency</li>
@endsection

@section('admin_content')

<link href="{{ asset('admin_assets/plugins/datatable/datatables.min.css') }}" rel="stylesheet">
<link href="{{ asset('admin_assets/plugins/datatable/responsive.dataTables.min.css') }}" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">

<style>
    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 6px 12px;
        margin-left: 8px;
    }
    .dataTables_wrapper .dataTables_length select {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 6px 12px;
        margin: 0 8px;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: var(--primary-bg-color, #6259ca) !important;
        color: #fff !important;
        border: none !important;
    }
    .currency-preview-card .preview-row {
        display: flex;
        justify-content: space-between;
        gap: 1rem;
        padding: 0.55rem 0;
        border-bottom: 1px solid #f0f2f8;
    }
    .currency-preview-card .preview-row:last-child {
        border-bottom: 0;
    }
    .currency-preview-card .preview-label {
        color: #6c757d;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }
    .currency-preview-card .preview-value {
        font-weight: 600;
        text-align: right;
    }
    .select2-container .select2-selection--single {
        height: 42px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 40px;
        padding-left: 12px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 40px;
    }
</style>

<div class="row row-sm">
    <div class="col-lg-12">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if (!empty($catalogError))
            <div class="alert alert-warning">
                Live currency catalog is unavailable: {{ $catalogError }}
            </div>
        @endif

        <div class="card mg-b-20">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                    <div>
                        <h4 class="card-title mg-b-5">Add International Currency</h4>
                        <p class="text-muted tx-12 mb-0">
                            Select a currency to load its live USD exchange rate, then save it to your active list.
                            @if (!empty($ratesMeta['updated_at']))
                                <br>Source rates last updated: {{ $ratesMeta['updated_at'] }}
                            @endif
                        </p>
                    </div>
                    <form action="{{ route('currency.sync-rates') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-primary btn-sm">
                            <i class="fe fe-refresh-cw me-1"></i> Refresh Active Rates
                        </button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('currency.store-from-catalog') }}" method="POST" id="add-currency-form">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label for="catalog-currency-code" class="form-label">Select Currency</label>
                            <select id="catalog-currency-code" name="code" class="form-control" required @disabled(empty($availableCurrencies))>
                                <option value="">Choose a currency...</option>
                                @foreach ($availableCurrencies as $code => $name)
                                    <option value="{{ $code }}">{{ $code }} — {{ $name }}</option>
                                @endforeach
                            </select>
                            @if (empty($availableCurrencies) && empty($catalogError))
                                <p class="text-muted tx-12 mt-2 mb-0">All supported currencies are already in your list.</p>
                            @endif
                        </div>
                        <div class="col-lg-3 mb-3">
                            <label for="catalog-is-active" class="form-label">Status</label>
                            <select id="catalog-is-active" name="is_active" class="form-control">
                                <option value="1" selected>Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <div class="col-lg-3 mb-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100" id="save-currency-btn" disabled>
                                <i class="fe fe-save me-1"></i> Save to Active List
                            </button>
                        </div>
                    </div>
                </form>

                <div class="row mt-2">
                    <div class="col-lg-8">
                        <div class="card currency-preview-card border bg-light">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="mb-0">Currency Details</h6>
                                    <span class="badge bg-primary-transparent" id="preview-loading" style="display:none;">Loading...</span>
                                </div>
                                <div class="preview-row">
                                    <div class="preview-label">Name</div>
                                    <div class="preview-value" id="preview-name">—</div>
                                </div>
                                <div class="preview-row">
                                    <div class="preview-label">Code</div>
                                    <div class="preview-value" id="preview-code">—</div>
                                </div>
                                <div class="preview-row">
                                    <div class="preview-label">Symbol</div>
                                    <div class="preview-value" id="preview-symbol">—</div>
                                </div>
                                <div class="preview-row">
                                    <div class="preview-label">Rate vs 1 USD</div>
                                    <div class="preview-value" id="preview-rate">—</div>
                                </div>
                                <div class="preview-row">
                                    <div class="preview-label">Source Updated</div>
                                    <div class="preview-value" id="preview-updated">—</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title mg-b-10">Active Currency List</h4>
                        <p class="text-muted tx-12 mb-0">Currencies available across the platform. Rates sync daily against USD.</p>
                    </div>
                    <span class="badge bg-primary-transparent tx-13">{{ count($data) }} {{ Str::plural('currency', count($data)) }}</span>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered text-nowrap mb-0 dataTables" id="file-datatable">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Name</th>
                                <th>Code</th>
                                <th>Symbol</th>
                                <th>Rate (1 USD)</th>
                                <th>Rate Updated</th>
                                <th>Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $index => $val)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><span class="font-weight-semibold">{{ $val->name }}</span></td>
                                    <td>{{ $val->short_name }}</td>
                                    <td>{{ $val->symbol ?: '-' }}</td>
                                    <td>{{ number_format((float) $val->currency_rate, 4) }}</td>
                                    <td>
                                        @if (!empty($val->rate_updated_at))
                                            {{ \Illuminate\Support\Carbon::parse($val->rate_updated_at)->format('d M Y H:i') }}
                                        @else
                                            —
                                        @endif
                                    </td>
                                    <td>
                                        @if ($val->is_active == 1)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-warning">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <div class="table-action d-flex justify-content-end gap-1">
                                            <a href="{{ url('currency/view', $val->id) }}" class="btn btn-sm btn-info-light" title="View">
                                                <i class="far fa-eye"></i>
                                            </a>
                                            <a href="{{ url('currency/edit', $val->id) }}" class="btn btn-sm btn-success-light" title="Edit">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            @if (strtoupper((string) $val->short_name) !== 'USD')
                                                <form action="{{ url('currency/destroy', $val->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Remove this currency from your list?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger-light" title="Delete">
                                                        <i class="far fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center text-muted py-4" colspan="8">No currencies found</td>
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
(function () {
    const $select = $('#catalog-currency-code');
    const $saveBtn = $('#save-currency-btn');
    const previewUrl = @json(route('currency.preview'));

    function resetPreview() {
        $('#preview-name, #preview-code, #preview-symbol, #preview-rate, #preview-updated').text('—');
        $saveBtn.prop('disabled', true);
    }

    function setPreview(data) {
        $('#preview-name').text(data.name || '—');
        $('#preview-code').text(data.code || '—');
        $('#preview-symbol').text(data.symbol || '—');
        $('#preview-rate').text(data.rate != null ? Number(data.rate).toFixed(4) : '—');
        $('#preview-updated').text(data.updated_at || '—');
        $saveBtn.prop('disabled', !data.code);
    }

    if ($select.length) {
        $select.select2({
            width: '100%',
            placeholder: 'Choose a currency...',
            allowClear: true
        });

        $select.on('change', function () {
            const code = $(this).val();
            if (!code) {
                resetPreview();
                return;
            }

            $('#preview-loading').show();
            $saveBtn.prop('disabled', true);

            $.ajax({
                url: previewUrl,
                method: 'GET',
                data: { code: code },
                success: function (response) {
                    if (response.success && response.data) {
                        setPreview(response.data);
                    } else {
                        resetPreview();
                        alert(response.message || 'Unable to load currency details.');
                    }
                },
                error: function (xhr) {
                    resetPreview();
                    const message = xhr.responseJSON && xhr.responseJSON.message
                        ? xhr.responseJSON.message
                        : 'Unable to load currency details.';
                    alert(message);
                },
                complete: function () {
                    $('#preview-loading').hide();
                }
            });
        });
    }
})();
</script>

@php
    $datatableJqueryLoaded = true;
    $datatableOptions = [
        'language' => [
            'search' => 'Search:',
            'searchPlaceholder' => 'Search currencies...',
            'zeroRecords' => 'No matching currencies found',
        ],
        'columnDefs' => [
            ['orderable' => false, 'targets' => [7]],
            ['searchable' => false, 'targets' => [0, 7]],
        ],
    ];
@endphp
@include('datatable.datatable_js')
@endpush
