<script src="{{ asset('admin_assets/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{asset('admin_assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
{{-- <script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.3.min.js"></script> --}}
<script src="{{asset('admin_assets/plugins/datatable/js/dataTables.bootstrap5.js')}}"></script>
<script src="{{asset('admin_assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('admin_assets/plugins/datatable/js/buttons.bootstrap5.min.js')}}"></script>
<script src="{{asset('admin_assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{asset('admin_assets/plugins/datatable/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('admin_assets/plugins/datatable/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('admin_assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('admin_assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{asset('admin_assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{asset('admin_assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('admin_assets/plugins/datatable/responsive.bootstrap5.min.js')}}"></script>

{{-- <script src="{{asset('admin_assets/js/table-data.js')}}"></script> --}}
<script>
$(document).ready(function () {
    $.noConflict();
    
    // Initialize file-datatable without buttons (if exists)
    if ($('#file-datatable').length) {
        var table = $('#file-datatable').DataTable({
            language: {
                searchPlaceholder: 'Search...',
                scrollX: "100%",
                sSearch: '',
            }
        });
    }
    
    // Initialize other dataTables
    $('.dataTables').not('#file-datatable').DataTable({
        language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
        }
    });
});
</script>
