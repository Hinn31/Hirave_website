<head>
    <link rel="stylesheet" href="{{ asset('css/homepage.css') }}">
</head>

@extends('layouts.master')
@section('title', 'Homepage')
@section('content')

<div class="home-page">
    {{-- Hero --}}
    <div class="hero">
        <div class="hero__content">
            <h2 class="hero__title">Ring packs and matching sets</h2>
            <p class="hero__subtitle">Now only - Limited time only</p>
            <button class="hero__button">Shop Now</button>
        </div>
        <div class="hero__image">
            <img src="https://afamilycdn.com/150157425591193600/2021/12/3/8aeaa038-813f-455e-a0c6-2dbba66ed205-16384373902831634886359-1638502651569-16385026516831865084947.jpeg" alt="Banner">
        </div>
    </div>
    {{-- service-highlights --}}
    <div class="service-highlights">
        <div class="service__item">
            <i class="service__icon fa fa-truck"></i>
            <p class="service__text">Free Shipping<br>Tell about your service.</p>
        </div>
        <div class="service__item">
            <i class="service__icon fa fa-dollar-sign"></i>
            <p class="service__text">Money Guarantee<br>Within 30 days for an exchange.</p>
        </div>
        <div class="service__item">
            <i class="service__icon fa fa-headphones"></i>
            <p class="service__text">Online Support<br>24 hours a day, 7 days a week.</p>
        </div>
    </div>
    {{-- Carousel  --}}
    <div class="carousel">
        <div class="slideshow-container">
            <div class="mySlides fade">
                <img src="https://cdnmedia.baotintuc.vn/Upload/cVJiASFv9S8nriO7eNwA/files/2023/03/8-3/image005.jpg" alt="Slide 1">
            </div>

            <div class="mySlides fade">
                <img src="https://bacminhcanh.com/wp-content/uploads/2016/08/4-loi-su-dung-trang-suc-bac.jpg" alt="Slide 2">
            </div>

            <div class="mySlides fade">
                <img src="https://eropi.com/media/wysiwyg/bo-trang-suc-5/bo-trang-suc-bac-the-paper-fan_1_.JPG" alt="Slide 3">
            </div>

            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
            <a class="next" onclick="plusSlides(1)">&#10095;</a>
        </div>
        <div class="dot-container">
            <span class="dot" onclick="currentSlide(1)"></span>
            <span class="dot" onclick="currentSlide(2)"></span>
            <span class="dot" onclick="currentSlide(3)"></span>
        </div>
    </div>

    <div class="hot-products">
        <h2 class="hot-products__title">Hot Product</h2>
        <div class="hot-products__list">
            @include('components.product-card-mini', ['products' => $products])
        </div>
    </div>

</div>
<script src="{{ asset('js/carousel.js') }}"></script>
@endsection