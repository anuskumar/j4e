@extends('layout.mainlayout')
@section('content')

<style>
    .cms-page-content {
        padding: 40px 0 60px;
        background: #f8f9fc;
    }

    .cms-page-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #e8ebf3;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
        padding: 32px 36px;
    }

    .cms-page-card h1,
    .cms-page-card h2,
    .cms-page-card h3,
    .cms-page-card h4 {
        color: #1f2937;
        margin-top: 1.25rem;
        margin-bottom: 0.75rem;
        font-weight: 700;
    }

    .cms-page-card h1:first-child,
    .cms-page-card h2:first-child,
    .cms-page-card h3:first-child,
    .cms-page-card h4:first-child {
        margin-top: 0;
    }

    .cms-page-card p,
    .cms-page-card li {
        color: #4b5563;
        line-height: 1.7;
        font-size: 15px;
    }

    .cms-page-card ul,
    .cms-page-card ol {
        padding-left: 1.25rem;
        margin-bottom: 1rem;
    }

    @media (max-width: 767px) {
        .cms-page-card {
            padding: 24px 18px;
        }
    }
</style>

<div class="breadcrumb-bar">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $page->title }}</li>
                    </ol>
                </nav>
                <h2 class="breadcrumb-title">{{ $page->title }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="content cms-page-content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="cms-page-card terms-content">
                    @if (filled($page->content))
                        {!! $page->content !!}
                    @else
                        <p class="mb-0 text-muted">Content for this page has not been published yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
