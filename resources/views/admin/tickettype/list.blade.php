<?php $page = 'tickettype/list'; ?>
@extends('admin.layout.app')

@section('page_title', 'Ticket Types')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Ticket Types</li>
@endsection

@section('admin_content')

<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title mg-b-10">Ticket Types</h4>
                        <p class="text-muted tx-12 mb-0">Master data list of available ticket types.</p>
                    </div>
                    <span class="badge bg-primary-transparent tx-13">{{ count($data) }} {{ Str::plural('type', count($data)) }}</span>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="file-datatable" class="border-top-0 dataTables table table-bordered text-nowrap key-buttons border-bottom">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th class="border-bottom-0">Ticket Type Name</th>
                                <th class="border-bottom-0">Description</th>
                                <th class="border-bottom-0">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $index => $val)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><span class="font-weight-semibold">{{ $val->ticket_type_name }}</span></td>
                                <td>{{ $val->description ?: '-' }}</td>
                                <td>
                                    @if ($val->is_active == 1)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-warning">Inactive</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td class="text-center text-muted py-4">No ticket types found</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@include('datatable.datatable_js')
@endsection
