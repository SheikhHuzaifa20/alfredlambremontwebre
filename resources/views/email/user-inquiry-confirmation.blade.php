<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Message Received</title>
</head>

<body>

    <h2>Hello {{ $inquiry->fname }},</h2>

    <p>
        Thank you for contacting us.
    </p>

    <p>
        We have received your message and our team will get back to you as soon as possible.
    </p>

    <p>
        <strong>Your message:</strong>
    </p>

    <p>
        {{ $inquiry->notes }}
    </p>

    <br>

    <p>
        Best regards,<br>
        {{ config('app.name') }}
    </p>

</body>
</html>