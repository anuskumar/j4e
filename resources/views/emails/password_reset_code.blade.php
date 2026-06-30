<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Code</title>
</head>
<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f6fb;">
    <div style="max-width: 560px; margin: 32px auto; padding: 32px; background: #ffffff; border-radius: 12px; border: 1px solid #e8ebf3;">
        <div style="text-align: center; margin-bottom: 24px;">
            <img src="{{ $logoUrl }}" alt="{{ $appName }}" style="max-width: 180px; height: auto;">
        </div>

        <h2 style="color: #1f2937; margin: 0 0 12px; font-size: 22px;">Reset your password</h2>
        <p style="color: #4b5563; line-height: 1.6; margin: 0 0 20px;">
            Hi {{ $user->name ?? 'there' }}, use the verification code below to reset your password. This code expires in {{ $expiresMinutes }} minutes.
        </p>

        <div style="text-align: center; margin: 28px 0;">
            <span style="display: inline-block; letter-spacing: 8px; font-size: 32px; font-weight: 700; color: #221e69; background: #f4f0ff; padding: 16px 24px; border-radius: 10px;">
                {{ $code }}
            </span>
        </div>

        <p style="color: #6b7280; font-size: 14px; line-height: 1.6; margin: 0;">
            If you did not request a password reset, you can safely ignore this email. Your password will remain unchanged.
        </p>
    </div>
</body>
</html>
