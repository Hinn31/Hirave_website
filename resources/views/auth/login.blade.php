@extends('layouts.auth', [
    'title' => 'Login',
    'image' => 'images/login.jpg',
    'message' => 'Welcome Back!'
])

@section('content')
<div class="login">
<h2 class="auth-title">Login</h2>

  <form method="POST" action="{{ route('login') }}">
    @csrf

     <div class="auth-group">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" class="auth-input" placeholder="Your email" required>
    </div>

     <div class="auth-group">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" class="auth-input" placeholder="Enter password" required>
    </div>

    <button type="submit" class="auth-button">Login</button>

       <p class="auth-bottom-text">
        Don't have an account? <a href="{{ route('login') }}">Register here</a>
    </p>
  </form>
</div>
@endsection
