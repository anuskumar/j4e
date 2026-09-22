<?php $page = 'cms-pages/list'; ?>
@extends('admin.layout.app')

@section('page_title', 'CMS Pages')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">CMS Pages</li>
@endsection

@section('admin_content')

<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <h4 class="card-title mg-b-10">CMS Pages</h4>
                        <p class="text-muted tx-12 mb-0">Manage dynamic public pages such as Terms and Conditions.</p>
                    </div>
                    <span class="badge bg-primary-transparent tx-13">
                        {{ count($data) }} {{ \Illuminate\Support\Str::plural('page', count($data)) }}
                    </span>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered text-nowrap mb-0">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Title</th>
                                <th>Slug / URL</th>
                                <th>Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $index => $val)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td class="fw-semibold">{{ $val->title }}</td>
                                    <td>
                                        <a href="{{ $val->publicUrl() }}" target="_blank" rel="noopener noreferrer">
                                            /{{ $val->slug }}
                                        </a>
                                    </td>
                                    <td>
                                        @if ($val->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-warning">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.cms-pages.edit', $val->id) }}" class="btn btn-sm btn-success-light" title="Edit">
                                            <i class="far fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">No CMS pages found. Run the CmsPageSeeder.</td>
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
