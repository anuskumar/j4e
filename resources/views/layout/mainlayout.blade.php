<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
		<meta name="Author" content="Spruko Technologies Private Limited">
		<meta name="Keywords" content="admin,admin dashboard,admin dashboard template,admin panel template,admin template,admin theme,bootstrap 4 admin template,bootstrap 4 dashboard,bootstrap admin,bootstrap admin dashboard,bootstrap admin panel,bootstrap admin template,bootstrap admin theme,bootstrap dashboard,bootstrap form template,bootstrap panel,bootstrap ui kit,dashboard bootstrap 4,dashboard design,dashboard html,dashboard template,dashboard ui kit,envato templates,flat ui,html,html and css templates,html dashboard template,html5,jquery html,premium,premium quality,sidebar bootstrap 4,template admin bootstrap 4"/>

		<!-- Title -->

        <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('layout.partials.head')
    <script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>
    
  </head>
  @if(Route::is(['page']))
  <body class="home-page">
  @endif
  @if(Route::is(['map-grid','map-list']))
  <body class="map-page">
  @endif
  @if(Route::is(['chat-speaker','chat']))
  <body class="chat-page">
  @endif
  @if(Route::is(['forgot-password','login','register','speaker-register']))
  <body class="account-page">
  @endif
  @if(Route::is(['video-call','voice-call']))
  <body class="call-page">
  @endif
{{-- @include('layout.partials.header') --}}
@include('layout.partials.header')
@yield('content')
@if(!Route::is(['chat-instructor','map-grid','map-list','chat','voice-call','video-call']))
@include('layout.partials.footer')
@endif


@include('layout.partials.footer-scripts')
    {{-- <script>
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-left",
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "37777777700",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }

        @if (Session::has('success'))

        // console.log('got success');
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.success("{{ session('success') }}");
        @endif

        @if (Session::has('error'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.error("{{ session('error') }}");
        @endif

        @if (Session::has('danger'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.error("{{ session('danger') }}");
        @endif

        @if (Session::has('info'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.info("{{ session('info') }}");
        @endif

        @if (Session::has('warning'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.warning("{{ session('warning') }}");
        @endif
    </script> --}}

<script type="text/javascript">
    $('.show_confirm').click(function(event) {
        var form = $(this).closest("form");
        var name = $(this).data("name");
        event.preventDefault();
        swal({
                title: `Are you sure you want to delete this record?`,
                text: "If you delete this, it will be gone forever.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    form.submit();
                }
            });
    });

    @if ($errors->any())
        console.warn("Validation error: {{ $errors->first() }}");
    @endif
</script>
  </body>
</html>
