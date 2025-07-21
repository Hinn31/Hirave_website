<!DOCTYPE html>
<html lang="vi">
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta charset="UTF-8">
    <title>Trang chủ - Hivera</title>
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">

</head>
<body>

    {{-- Gọi component header --}}
    @include('components.header')

    <main style="padding: 20px;">
        <h2>Trang chủ</h2>
        <p>Đây là nội dung trang chủ của bạn.</p>
    </main>

</body>
</html>
