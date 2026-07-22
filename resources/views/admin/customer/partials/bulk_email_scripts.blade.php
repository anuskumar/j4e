@include('admin.partials.bulk_email_scripts', [
    'emailPrefix' => 'customer',
    'sendRoute' => route('admin.customer.send-email'),
    'recipientIdsField' => 'customer_ids',
])
