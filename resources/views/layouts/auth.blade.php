<!-- resources/views/layouts/auth.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Auth' }}</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-image">
            <img src="{{ asset($image ?? 'images/default.jpg') }}" alt="Auth Image">
            <div class="auth-overlay">
                {{ $message ?? 'Welcome!' }}
            </div>
        </div>

        <div class="auth-form">
            @yield('content')
        </div>
    </div>
</body>
</html>
