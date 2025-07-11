<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/reset-password.css')}}">
    <title>Verification</title>
</head>
<body>
    <div class="verification">
        <form action="#" class="verification__form">
            <h3 class="verification__title">Verification</h3>
            <p class="verification__description">Enter your 4 digits code that you received on your email.</p>
            <div class="verification__input-group">
                <input type="number" class="verification__input">
                <input type="number" class="verification__input">
                <input type="number" class="verification__input">
                <input type="number" class="verification__input">
            </div>
            <p class="verification__countdown">00:30</p>
            <button class="verification__button">CONTINUE</button>
            <p class="verification__resend">If you didn’t receive a code! <a href="#">Resend</a></p>
        </form>
    </div>
</body>
</html>
