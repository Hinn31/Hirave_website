<header class="header" style="display: flex; justify-content: space-between; align-items: center; padding: 10px 20px; background-color: #f2f2f2;">
<link rel="stylesheet" href="{{ asset('css/header.css') }}">
 
<!-- Logo bên trái -->
<div class="header-left">
    <div class="logo">
        <h1 style="margin: 0;">Hivera</h1>
    </div>
</div>

<nav class="header-nav" style="display: flex; gap: 20px;">
    <a class="nav-link" href="{{ url('/trang-chu') }}">Home</a>
    <a class="nav-link" href="{{ url('/Productpage') }}">Product</a>
    <a class="nav-link" href="{{ url('/about') }}">About Us</a>
    <a class="nav-link" href="{{ url('/contact') }}">Contact</a>
</nav>

<div class="icons" style="display: flex; align-items: center; gap: 10px;">
    <form action="{{ route('products.search') }}" method="GET" style="display: flex; gap: 5px;">
        <input type="text" name="keyword" placeholder="Search..." required style="padding: 5px;" value="{{ request('keyword') }}">
        <button type="submit" style="padding: 5px 10px;">Search</button>
    </form>

    <!-- Nút User -->
    <a id="user-link">
        <i class="fas fa-user"></i>
    </a>

    <!-- Giỏ hàng -->
       <a href="{{ route('cart.page') }}">
    <i class="fas fa-shopping-cart"></i>
</a>
    
</div>
</header>

<script>
document.addEventListener('DOMContentLoaded', async function() {
    const token = localStorage.getItem('token');
    const userLink = document.getElementById('user-link');

    if (token) {
        try {
            const res = await fetch('http://127.0.0.1:8000/api/user', {
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json'
                }
            });
            const data = await res.json();

            if (res.ok && data.id) {
                userLink.setAttribute('href', `/profile/user/${data.id}`);
                userLink.setAttribute('title', 'Hồ sơ');
            } else {
                userLink.setAttribute('href', '/login');
                userLink.setAttribute('title', 'Đăng nhập');
            }
        } catch (e) {
            console.error(e);
            userLink.setAttribute('href', '/login');
            userLink.setAttribute('title', 'Đăng nhập');
        }
    } else {
        userLink.setAttribute('href', '/login');
        userLink.setAttribute('title', 'Đăng nhập');
    }
});

</script>
