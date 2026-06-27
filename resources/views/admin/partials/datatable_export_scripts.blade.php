<script>
jQuery(function ($) {
    var tableSelector = @json($exportTableSelector ?? '#file-datatable');
    var excelSelector = @json('#' . ($exportExcelId ?? 'export-excel'));
    var pdfSelector = @json('#' . ($exportPdfId ?? 'export-pdf'));

    if (!$.fn.DataTable.isDataTable(tableSelector) || !$.fn.dataTable.Buttons) {
        return;
    }

    var table = $(tableSelector).DataTable();

    new $.fn.dataTable.Buttons(table, {
        buttons: @json($exportButtons)
    });

    $(excelSelector).on('click', function () {
        table.button(0).trigger();
    });

    $(pdfSelector).on('click', function () {
        table.button(1).trigger();
    });
});
</script>
