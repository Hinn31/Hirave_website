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
          <input type="email" name="email" id="email" class="auth-input" placeholder="Your email" required autocomplete="off">
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
          <a href="{{ route('forgot.password.form') }}">Forgot Password?</a>
      </p>
      <p id="login-message" style="margin-top: 10px; color: red;"></p>
  </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('login-form');
  const messageBox = document.getElementById('login-message');
  const userLink = document.getElementById('user-link'); // nếu có user link trên trang

  form.addEventListener('submit', async function (e) {
      e.preventDefault();

      const email = document.getElementById('email').value.trim();
      const password = document.getElementById('password').value.trim();

      messageBox.textContent = '';

      try {
          const response = await fetch('http://127.0.0.1:8000/api/login', {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json',
                  'Accept': 'application/json'
              },
              body: JSON.stringify({ email, password })
          });

          if (!response.ok) {
              const errorData = await response.json();
              messageBox.textContent = errorData.message || 'Login failed';
              return;
          }

          const data = await response.json();

          if (data.token) {
              // Lưu token vào localStorage
              localStorage.setItem('token', data.token);

              // Nếu có userLink trên trang thì cập nhật link hồ sơ
              if (userLink) {
                  try {
                      const res = await fetch('http://127.0.0.1:8000/api/user', {
                          headers: {
                              'Authorization': 'Bearer ' + data.token,
                              'Accept': 'application/json'
                          }
                      });
                      if (res.ok) {
                          const userData = await res.json();
                          userLink.setAttribute('href', `/profile/user/${userData.id}`);
                          userLink.setAttribute('title', 'Hồ sơ');
                      } else {
                          userLink.setAttribute('href', '/login');
                          userLink.setAttribute('title', 'Đăng nhập');
                      }
                  } catch {
                      userLink.setAttribute('href', '/login');
                      userLink.setAttribute('title', 'Đăng nhập');
                  }
              }

              // Điều hướng sau khi login thành công tới trang giỏ hàng
              window.location.href = '/cart';
          } else {
              messageBox.textContent = 'Login failed: Token not received';
          }
      } catch (error) {
          console.error(error);
          messageBox.textContent = 'Đã có lỗi xảy ra khi đăng nhập.';
      }
  });
});
</script>
@endsection
