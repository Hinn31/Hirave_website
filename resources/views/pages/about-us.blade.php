<header>
  <link rel="stylesheet" href="{{ asset('css/about-us.css') }}">
</header>
@extends('layouts.master')
@section('title', 'About Us')

@section('content')

<!-- Banner nhỏ -->
<div class="about-page-banner">
    <h1>ABOUT US</h1>
    <p><a href="/">HOME</a> / ABOUT US</p>
</div>

<!-- About Section -->
<div class="about-section">
    <div class="about-wrapper">
        <div class="about-img">
            <img src="{{asset('images/abouts/about-2.png')}}" alt="Hivera Jewelry">        </div>
        <div class="about-text">
            <h3>WE ARE CRAZY FASHION</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore...</p>
            <ul>
                <li><em>Who you are</em></li>
                <li><em>Why you sell the items you sell</em></li>
                <li><em>Where you are located</em></li>
                <li><em>How long you have been in business</em></li>
            </ul>
            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium...</p>
        </div>
    </div>
</div>

@endsection
