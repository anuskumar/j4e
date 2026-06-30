@include('admin.partials.datatable_export_scripts', [
    'exportButtons' => $resellerExportButtons,
    'exportExcelId' => 'reseller-export-excel',
    'exportPdfId' => 'reseller-export-pdf',
])
