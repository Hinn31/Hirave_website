@extends('layouts.auth', [
    'title' => 'Login',
    'image' => 'images/login.jpg',
    'message' => 'Welcome Back!'
])

@section('content')
<div class="login">
  <h2 class="auth-title">Login</h2>

<form id="login-form" autocomplete="off">
    <div class="auth-group">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" class="auth-input" placeholder="Your email"  required autocomplete="off">
    </div>

    <div class="auth-group">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" class="auth-input" placeholder="Enter password" required autocomplete="off">
    </div>

    <button type="submit" class="auth-button">Login</button>

    <p class="auth-bottom-text">
        Don't have an account? <a href="{{ route('register') }}">Register here</a>
    </p>
    <p class="auth-bottom-text">
        <a href="{{ route('forgot.password.form') }}">Fogot Password?</a>
    </p>
    <p id="login-message" style="margin-top: 10px; color: red;"></p>
  </form>
</div>


<script>
const form = document.getElementById('login-form');

form.addEventListener('submit', async function (e) {
    e.preventDefault(); // Ngăn không cho form reload trang

    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value.trim();
    const messageBox = document.getElementById('login-message');

    messageBox.textContent = ''; // Xóa thông báo cũ

    try {
        const response = await fetch('http://127.0.0.1:8000/api/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ email, password })
        });

        const data = await response.json();

        if (response.ok) {
            messageBox.style.color = 'green';
            messageBox.textContent = data.message || 'Login successful!';

            form.reset(); // ✅ Đã sửa đúng
            window.location.href = '/test'; // Chuyển trang sau khi login
        } else {
            messageBox.style.color = 'red';
            messageBox.textContent = data.message || 'Login failed!';
        }

    } catch (error) {
        console.error('Lỗi kết nối API:', error);
        messageBox.style.color = 'red';
        messageBox.textContent = 'Lỗi kết nối đến máy chủ.';
    }
});
</script>

@endsection
