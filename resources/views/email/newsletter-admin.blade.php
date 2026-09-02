<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Newsletter Subscriber</title>
    <style>
        body { font-family: Georgia, serif; background: #0B1026; color: #EDE7DA; margin: 0; padding: 0; }
        .wrap { max-width: 560px; margin: 0 auto; padding: 40px 24px; }
        .header { border-bottom: 1px solid #2A3060; padding-bottom: 24px; margin-bottom: 30px; }
        .header h1 { font-size: 22px; color: #C8A24B; margin: 0 0 6px; font-weight: 400; }
        .header p { font-size: 12px; color: #8A8575; margin: 0; letter-spacing: 0.1em; text-transform: uppercase; }
        .body p { font-size: 16px; line-height: 1.7; color: #C4BEB1; }
        .highlight { background: #1D2452; border-left: 3px solid #C8A24B; padding: 14px 18px; border-radius: 2px; margin: 20px 0; }
        .highlight strong { color: #C8A24B; font-family: monospace; font-size: 15px; }
        .footer { margin-top: 40px; border-top: 1px solid #2A3060; padding-top: 20px; font-size: 11px; color: #5A5549; }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="header">
            <h1>New Newsletter Subscriber</h1>
            <p>Alfred Lambremont Webre · Admin Notification</p>
        </div>
        <div class="body">
            <p>A new reader has subscribed to your newsletter.</p>
            <div class="highlight">
                <strong>{{ $subscriberEmail }}</strong>
            </div>
            <p>They will now receive updates on new titles, findings, and speaking engagements.</p>
        </div>
        <div class="footer">
            This is an automated notification from alfredlambremontwebre.com
        </div>
    </div>
</body>
</html>