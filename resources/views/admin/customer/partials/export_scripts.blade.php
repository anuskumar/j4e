@include('admin.partials.datatable_export_scripts', [
    'exportButtons' => $customerExportButtons,
    'exportExcelId' => 'customer-export-excel',
    'exportPdfId' => 'customer-export-pdf',
])
