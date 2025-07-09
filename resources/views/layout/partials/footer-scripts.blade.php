<!-- jQuery -->
		<script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>

		<!-- Bootstrap Core JS -->
		<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
		<!-- Owl Carousel -->
		<script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
		<!-- Fancybox JS -->
		<script src="{{ asset('assets/plugins/fancybox/jquery.fancybox.min.js') }}"></script>
			<!-- circle progress JS -->
		<script src="{{ asset('assets/js/circle-progress.min.js') }}"></script>
		<!-- Select2 JS -->
		<script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
		<!-- Dropzone JS -->
		<script src="{{ asset('assets/plugins/dropzone/dropzone.min.js') }}"></script>

		<!-- Bootstrap Tagsinput JS -->
		<script src="{{ asset('assets/plugins/bootstrap-tagsinput/js/bootstrap-tagsinput.js') }}"></script>

		<!-- Profile Settings JS -->
		<script src="{{ asset('assets/js/profile-settings.js') }}"></script>

		<!-- Datetimepicker JS -->
		<script src="{{ asset('assets/js/moment.min.js') }}"></script>
		<script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
		<script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
		<!-- Full Calendar JS -->
        <script src="{{ asset('assets/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/fullcalendar/fullcalendar.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/fullcalendar/jquery.fullcalendar.js') }}"></script>
		<!-- Sticky Sidebar JS -->
        <script src="{{ asset('assets/plugins/theia-sticky-sidebar/ResizeSensor.js') }}"></script>
        <script src="{{ asset('assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js') }}"></script>
        


		<!-- Custom JS -->
		<script src="{{ asset('assets/js/script.js') }}"></script>
		@if(Route::is(['map-grid','map-list']))
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD6adZVdzTvBpE2yBRK8cDfsss8QXChK0I"></script>
		<script src="{{ asset('assets/js/map.js') }}"></script>
		@endif
