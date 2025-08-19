<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Panel')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            background: #1a1a1a;
            color: #fff;
            font-family: Arial, sans-serif;
        }
        .sidebar {
            width: 220px;
            background: #222;
            height: 100vh;
            float: left;
        }
        .sidebar a {
            display: block;
            padding: 12px 15px;
            color: #fff;
            text-decoration: none;
            border-bottom: 1px solid #333;
        }
        .sidebar a:hover {
            background: #444;
        }
        .sidebar .active {
            background: #4682B4;
        }
        .content {
            margin-left: 220px;
            padding: 20px;
            min-height: 100vh;
            background: #f4f4f4;
            color: #000;
        }
        .card {
            background: #fff;
            border-radius: 5px;
            padding: 20px;
        }
        .table thead {
            background: #000;
            color: #fff;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">DashBoard</a>
        <a href="{{ route('product-management.index') }}" class="{{ request()->routeIs('products.*') ? 'active' : '' }}">Product Management</a>
        <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'active' : '' }}">User management</a>
        <a href="{{ route('orders.index') }}" class="{{ request()->routeIs('orders.*') ? 'active' : '' }}">Order management</a>
        <a href="{{ route('messages.index') }}" class="{{ request()->routeIs('messages.*') ? 'active' : '' }}">Message management</a>
    </div>

    <!-- Content -->
    <div class="content">
        <div class="card">
            @yield('content')
        </div>
    </div>

</body>
</html>
