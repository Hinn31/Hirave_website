<head>
    <link rel="stylesheet" href="{{ asset('css/homepage.css') }}">
</head>

@extends('layouts.master')
@section('title', 'Homepage')
@section('content')

<div class="home-page">
    <div class="hero" style="background-image: url('{{ asset('images/abouts/banner_1.jpg') }}')">
    <div class="hero__content">
        <h1 class="hero__title">Welcome to Hivera Jewelry</h1>
        <p class="hero__subtitle">Discover timeless elegance</p>
        <button class="hero__button">Shop Now</button>
    </div>
</div>
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
            <img src="{{asset('images/abouts/banner_2.jpg')}}" alt="Hivera Jewelry">        </div>
            </div>

            <div class="mySlides fade">
            <img src="{{asset('images/abouts/banner_3.jpg')}}" alt="Hivera Jewelry">        </div>
            </div>

            <div class="mySlides fade">
            <img src="{{asset('images/abouts/banner_4.jpg')}}" alt="Hivera Jewelry">        </div>
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
