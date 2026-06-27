@if (!isset($datatableJqueryLoaded))
    <script src="{{ asset('admin_assets/plugins/jquery/jquery.min.js') }}"></script>
@endif
<script src="{{ asset('admin_assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin_assets/plugins/datatable/js/dataTables.bootstrap5.js') }}"></script>
<script src="{{ asset('admin_assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('admin_assets/plugins/datatable/js/buttons.bootstrap5.min.js') }}"></script>
<script src="{{ asset('admin_assets/plugins/datatable/js/jszip.min.js') }}"></script>
<script src="{{ asset('admin_assets/plugins/datatable/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('admin_assets/plugins/datatable/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('admin_assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('admin_assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('admin_assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('admin_assets/plugins/datatable/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('admin_assets/plugins/datatable/responsive.bootstrap5.min.js') }}"></script>

<script>
jQuery(document).ready(function ($) {
    var defaultDom = '<"row mb-3"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rt<"row mt-3"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>';
    var defaultLanguage = {
        searchPlaceholder: 'Search...',
        search: 'Search:',
        lengthMenu: 'Show _MENU_ entries',
        info: 'Showing _START_ to _END_ of _TOTAL_ entries',
        infoEmpty: 'No entries found',
        infoFiltered: '(filtered from _MAX_ total entries)',
        zeroRecords: 'No matching records found',
        paginate: {
            first: 'First',
            last: 'Last',
            next: 'Next',
            previous: 'Previous'
        }
    };

    var fileTableOptions = {
        order: [[0, 'asc']],
        pageLength: 25,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
        responsive: true,
        processing: true,
        dom: defaultDom,
        language: defaultLanguage,
        columnDefs: [
            { orderable: false, targets: -1 },
            { searchable: false, targets: [0, -1] }
        ]
    };

    @if (!empty($datatableOptions))
        fileTableOptions = $.extend(true, {}, fileTableOptions, @json($datatableOptions));
    @endif

    if ($('#file-datatable').length && !$.fn.DataTable.isDataTable('#file-datatable')) {
        $('#file-datatable').DataTable(fileTableOptions);
    }

    $('.dataTables').not('#file-datatable').each(function () {
        if (!$.fn.DataTable.isDataTable(this)) {
            $(this).DataTable({
                pageLength: 25,
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
                responsive: true,
                dom: defaultDom,
                language: defaultLanguage
            });
        }
    });
});
</script>
