<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Trang chủ - Hivera')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    @include('components.header')

    <main style="padding: 10px;">
        @yield('content')
    </main>
    @include('components.footer')

</body>
</html>
