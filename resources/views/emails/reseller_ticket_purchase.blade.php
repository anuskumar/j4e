<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Sold Notification</title>
</head>
<body style="font-family: Arial, sans-serif; background: #f7f7f7; padding: 20px;">
    <div style="max-width: 620px; margin: 0 auto; background: #ffffff; border-radius: 8px; padding: 20px;">
        <h2 style="margin-top: 0;">Ticket Sold Notification</h2>
        <p>Hi {{ $resellerName }},</p>
        <p>A customer has completed a ticket purchase:</p>

        <ul>
            <li><strong>Purchase ID:</strong> #{{ $purchaseId }}</li>
            <li><strong>Customer:</strong> {{ $customerName }}</li>
            <li><strong>Event:</strong> {{ $eventName }}</li>
            <li><strong>Event Date:</strong> {{ $eventDate }}</li>
            <li><strong>Ticket:</strong> {{ $ticketName }}</li>
            <li><strong>Ticket Count:</strong> {{ $ticketCount }}</li>
            <li><strong>Total Amount:</strong> {{ number_format($totalAmount, 2) }} {{ $currency }}</li>
        </ul>

        <p>Please proceed with your fulfillment process if required.</p>
    </div>
</body>
</html>

