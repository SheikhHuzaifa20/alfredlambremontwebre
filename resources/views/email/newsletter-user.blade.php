<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to the Newsletter</title>
    <style>
        body {
            font-family: Georgia, serif;
            background: #0B1026;
            color: #EDE7DA;
            margin: 0;
            padding: 0;
        }

        .wrap {
            max-width: 560px;
            margin: 0 auto;
            padding: 40px 24px;
        }

        .header {
            text-align: center;
            padding-bottom: 30px;
            border-bottom: 1px solid #2A3060;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 26px;
            color: #C8A24B;
            margin: 0 0 8px;
            font-weight: 400;
            letter-spacing: -0.01em;
        }

        .header p {
            font-size: 12px;
            color: #8A8575;
            margin: 0;
            letter-spacing: 0.12em;
            text-transform: uppercase;
        }

        .body p {
            font-size: 16px;
            line-height: 1.75;
            color: #C4BEB1;
            margin: 0 0 18px;
        }

        .body p strong {
            color: #EDE7DA;
        }

        .cta {
            text-align: center;
            margin: 36px 0;
        }

        .cta a {
            display: inline-block;
            background: #C8A24B;
            color: #0B1026;
            text-decoration: none;
            font-family: monospace;
            font-size: 11px;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            padding: 14px 32px;
            border-radius: 2px;
        }

        .divider {
            border: none;
            border-top: 1px solid #2A3060;
            margin: 30px 0;
        }

        .footer {
            font-size: 11px;
            color: #5A5549;
            text-align: center;
            line-height: 1.6;
        }

        .footer a {
            color: #8A8575;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="wrap">
        <div class="header">
            <h1>Alfred Lambremont Webre</h1>
            <p>Newsletter · Confirmation</p>
        </div>
        <div class="body">
            <p>Thank you for subscribing.</p>
            <p>You'll receive <strong>an occasional letter</strong> — new titles, findings that did not make it into the
                books, and where Alfred will be speaking next.</p>
            <p>No spam. No sharing. Unsubscribe any time.</p>
        </div>
        <div class="cta">
            <a href="{{ config('app.url') }}">Browse the Catalogue</a>
        </div>
        <hr class="divider">
        <div class="footer">
            <p>You subscribed with <strong>{{ $subscriberEmail }}</strong></p>
            <p>© {{ date('Y') }} Alfred Lambremont Webre · All rights reserved</p>
        </div>
    </div>
</body>

</html>
