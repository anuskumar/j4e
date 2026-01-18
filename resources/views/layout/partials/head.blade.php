
        <meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
		<title>Events</title>

		<!-- Favicons -->
		<link type="image/x-icon" href="{{ asset('assets/img/favicon.png') }}" rel="icon">

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

		<!-- Fontawesome CSS -->
		<link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
		<link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">
		<link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">
		<link rel="stylesheet" href="{{ asset('assets/css/owl.theme.default.min.css') }}">
		<!-- Fancybox CSS -->
		<link rel="stylesheet" href="{{ asset('assets/plugins/fancybox/jquery.fancybox.min.css') }}">
		<!-- Daterangepikcer CSS -->
		<link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}">
		<!-- Datetimepicker CSS -->
		<link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
		<!-- Full Calander CSS -->
        <link rel="stylesheet" href="{{ asset('assets/plugins/fullcalendar/fullcalendar.min.css') }}">
		<!-- Select2 CSS -->
		<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-tagsinput/css/bootstrap-tagsinput.css') }}">
		<link rel="stylesheet" href="{{ asset('assets/plugins/dropzone/dropzone.min.css') }}">

		<!-- Main CSS -->
		<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

        <!-- Custom Mobile Responsive Styles -->
        <style>
        /* Hide all sidebar-related elements globally */
        .app-sidebar,
        .app-sidebar__overlay,
        .sidebar-mini .main-sidebar,
        .main-sidebar,
        .sidebar-scroll,
        .sidebar-right,
        .sidebar-animate,
        .navbar-header .bar-icon,
        #mobile_btn {
            display: none !important;
        }
        
        /* Global Mobile Fixes */
        @media (max-width: 991px) {
            body {
                overflow-x: hidden;
                padding: 0 !important;
                margin: 0 !important;
            }
            
            body.sidebar-mini {
                padding-left: 0 !important;
            }
            
            .container {
                max-width: 100%;
                padding-left: 15px;
                padding-right: 15px;
            }
            
            .main-wrapper {
                overflow-x: hidden;
                margin-left: 0 !important;
                padding-left: 0 !important;
            }
            
            img {
                max-width: 100%;
                height: auto;
            }
            
            /* Ensure no fixed sidebars on mobile */
            .theiaStickySidebar {
                position: relative !important;
            }
        }
        
        @media (max-width: 768px) {
            h1 {
                font-size: 24px;
            }
            
            h2 {
                font-size: 22px;
            }
            
            h3 {
                font-size: 18px;
            }
            
            .btn {
                font-size: 14px;
                padding: 8px 16px;
            }
        }
        </style>
        

