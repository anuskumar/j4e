@include('admin.partials.bulk_email_scripts', [
    'emailPrefix' => 'reseller',
    'sendRoute' => route('admin.reseller.send-email'),
    'recipientIdsField' => 'reseller_ids',
])
