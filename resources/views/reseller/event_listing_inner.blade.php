@extends('layouts.reseller_app')
@section('content')
    <div class="container mt-5">
        <div class="text-center mt-4">
            <h1>Sell Your Tickets</h1>
            <p>Mastro Tickets is the world’s largest secondary marketplace for tickets to live events</p>
        </div>
        <div class="text-center mt-5">
            <div class="input-group mx-auto" style="max-width: 768px;">
                <span class="input-group-text bg-white border-end-0">
                    <i class="bi bi-search"></i>
                </span>
                <input type="search" class="form-control border-start-0"
                    placeholder="Search your event and start listing" aria-label="Search">
            </div>
        </div>
        <h3 class="text-start mb-4 mt-5 text-primary">Popular Events</h3>
        <div class="row">
            @foreach ($eventdatas as $eventdata)
                <div class="col-xl-4 col-lg-4 col-md-6 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header bg-primary text-white text-center">
                            <h5 class="mb-0">{{ Str::ucfirst($eventdata->event_type_name) . ' Tickets' }}</h5>
                        </div>
                        <div class="card-body text-center">
                            <i class="text-danger si si-calendar display-4"></i>
                            <div class="d-flex flex-wrap justify-content-center gap-2 mt-3">
                                @foreach ($eventdata->tags as $val)
                                    <a style="background: rgb(247, 247, 247);"
                                        href="{{ url('reseller/event_list_withtag', $val->id) }}"
                                        class="btn">{{ $val->tag_name }}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
