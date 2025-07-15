@extends('layouts.auth', [
    'title' => 'Register',
    'image' => 'images/register.jpg',
    'message' => 'Ready to join something great?'
])

@section('content')
<h2 class="auth-title">Register</h2>

<form method="POST" action="{{ route('register') }}">
    @csrf

    <div class="auth-group">
        <label for="name">Username</label>
        <input type="text" name="name" id="name" class="auth-input" placeholder="Your name" required>
    </div>

    <div class="auth-group">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" class="auth-input" placeholder="Your email" required>
    </div>

    <div class="auth-group">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" class="auth-input" placeholder="Enter password" required>
    </div>

    <div class="auth-group">
        <label for="password_confirmation">Confirm Password</label>
        <input type="password" name="password_confirmation" id="password_confirmation" class="auth-input" placeholder="Re-enter password" required>
    </div>

    <button type="submit" class="auth-button">Register</button>

    <p class="auth-bottom-text">
        Already have an account? <a href="{{ route('login') }}">Login here</a>
    </p>
</form>
@endsection
