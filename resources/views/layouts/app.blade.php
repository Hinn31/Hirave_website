<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{ asset('css/reset-password.css') }}">
  <link rel="stylesheet" href="{{ asset('css/verify-email.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <title>@yield('title', 'Forgot Password')</title>
</head>
<body>
  <main>
    @yield('content')
    @if (Auth::user() && !Auth::user()->hasVerifiedEmail())
        <div class="alert alert-warning">
            Your email is not verified.
            <a href="{{ route('verification.notice') }}">Verify Now</a>
        </div>
    @endif
  </main>
</body>
</html>
