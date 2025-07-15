@extends('layouts.auth', [
    'title' => 'Register',
    'image' => 'images/register.jpg',
    'message' => 'Ready to join something great?'
])

@section('content')
<h2 class="auth-title">Register</h2>

<form id="registerForm">
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

{{-- JavaScript xử lý fetch --}}
<script>
document.getElementById('registerForm').addEventListener('submit', async function(e) {
    e.preventDefault(); // Ngăn reload

    const form = e.target;

    const data = {
        name: form.name.value,
        email: form.email.value,
        password: form.password.value,
        password_confirmation: form.password_confirmation.value
    };

    try {
        const response = await fetch('/api/register', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        });

        const result = await response.json();

        if (response.ok) {
            alert("🎉 Đăng ký thành công!");
            console.log(result);
            // Chuyển về login sau khi đăng ký
            window.location.href = "/login";
        } else {
            if (result.errors) {
                let message = '';
                for (const [field, msgs] of Object.entries(result.errors)) {
                    message += `- ${field}: ${msgs.join(', ')}\n`;
                }
                alert("❌ Lỗi:\n" + message);
            } else {
                alert("❌ Lỗi: " + result.message);
            }
        }
    } catch (err) {
        alert("⚠️ Lỗi kết nối tới máy chủ.");
        console.error(err);
    }
});
</script>
@endsection
