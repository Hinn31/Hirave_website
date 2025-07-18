<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verification Email</title>
</head>
<body>
    <h1>Hello {{ $name }}!</h1>

    <p>Thank you for registering an account at <strong>Hivera</strong>.</p>

    <p><strong>Your account details:</strong></p>
    <ul>
        <li><strong>Name:</strong> {{ $name }}</li>
        <li><strong>Email:</strong> {{ $email }}</li>
        <li><strong>Registered at:</strong> {{ $created_at->format('Y-m-d H:i:s') }}</li>
    </ul>

    <p>You can now login and start using all features.</p>

    <p><a href="{{ url('/login') }}">Click here to login</a></p>

    <p>Best regards,<br>OutfitOn Team</p>
</body>
</html>
