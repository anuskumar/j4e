<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ticket Rejected</title>
</head>
<body>
    <p>Hi {{ $resellername }},</p>

    <p>Your ticket listing has been rejected by admin.</p>

    <p><strong>Event:</strong> {{ $eventname }}</p>
    <p><strong>Date:</strong> {{ $eventdate }}</p>
    <p><strong>Ticket:</strong> {{ $ticketname }}</p>

    <p>Please review and update the ticket details, then submit again.</p>
</body>
</html>
