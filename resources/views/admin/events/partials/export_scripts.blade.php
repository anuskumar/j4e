@include('admin.partials.datatable_export_scripts', [
    'exportButtons' => $eventExportButtons,
    'exportExcelId' => 'event-export-excel',
    'exportPdfId' => 'event-export-pdf',
])
