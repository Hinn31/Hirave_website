<head>
    <link rel="stylesheet" href="{{ asset('css/about-us.css') }}">
</head>

@extends('layouts.master')
@section('title', 'About Us')
@section('content')

<!-- About Section -->
<div class="about-section">
  <!-- Intro -->
  <div class="about-intro">
    <div class="about-image">
      <img src="{{asset('images/abouts/about-1.png')}}" alt="Hivera Jewelry">
    </div>
    <div class="about-text">
      <h2 class="about-hivera">HIVERA</h2>
      <p class="hivera-description">
        Hivera was born from a passion for exquisite beauty and a desire to bring confidence and radiance to every woman.
        We believe that each piece of jewelry is not just an accessory but also a story of your own.
      </p>
    </div>
  </div>

  <!-- Core Values -->
  <div class="about-core-values">
    <div class="core-img">
      <img src="{{asset('images/abouts/about-2.png')}}" alt="Core Values">
    </div>
    <div class="core-text">
      <h3>Core Values</h3>
      <ul>
        <li>Superior Quality</li>
        <li>Exquisite Design</li>
        <li>Dedicated Service</li>
        <li>Customized</li>
      </ul>
    </div>
  </div>

  <!-- Bottom Image -->
  <div class="about-bottom-img">
    <img src="{{asset('images/abouts/about-3.png')}}" alt="Jewelry">
  </div>
</div>
@endsection
