<header class="header" style="display: flex; justify-content: space-between; align-items: center; padding: 10px 20px; background-color: #f2f2f2;">
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
        <a href="#"><i class="fas fa-user"></i></a>
        <a href="#"><i class="fas fa-shopping-cart"></i></a>
    </div>
    
</header>
