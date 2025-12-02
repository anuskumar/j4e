
<?php $page="companysettings/edit/update";?>
@extends('admin.layout.app')
@section('admin_content')
<div class="row row-sm">
    @foreach ( $eventdatalists as $eventdata)
    <div class="col-xl-4 col-lg-4 col-md-6">
        <div class="card mg-b-20 text-center">
            <div class="card-body h-100">
                @if($eventdata->event_image)
                    <img src="{{ asset('storage/uploads/events/' . $eventdata->event_image) }}" alt="fff" class="wd-35p" style="width: 127px; height:84px;" onerror="this.src='{{ asset('assets/img/default-event.jpg') }}'">
                @else
                    <img src="{{ asset('assets/img/default-event.jpg') }}" alt="fff" class="wd-35p" style="width: 127px; height:84px;">
                @endif
                <h5 class="mg-b-10 mg-t-15 tx-18">{{$eventdata->event_name }}</h5>
                <span>{{$eventdata->event_desc }}</span><br>
                <a href="javascript:void(0);" class="text-dark">Check The Settings</a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
