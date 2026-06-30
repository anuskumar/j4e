<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $mailSubject }}</title>
</head>
<body style="font-family: Arial, sans-serif; background: #f7f7f7; padding: 20px; margin: 0;">
    <div style="max-width: 620px; margin: 0 auto; background: #ffffff; border-radius: 8px; padding: 24px;">
        <p style="margin-top: 0;">Hi {{ $recipientName }},</p>
        <div>{!! $mailBody !!}</div>
        <p style="margin-bottom: 0; color: #666;">Regards,<br>{{ config('app.name') }}</p>
    </div>
</body>
</html>
