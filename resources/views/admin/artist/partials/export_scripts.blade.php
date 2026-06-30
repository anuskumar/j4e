@include('admin.partials.datatable_export_scripts', [
    'exportButtons' => $artistExportButtons,
    'exportExcelId' => 'artist-export-excel',
    'exportPdfId' => 'artist-export-pdf',
])
