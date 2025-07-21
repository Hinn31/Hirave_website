@extends('layouts.app')
@section('title', 'Product Page')
@section('content')

<div class="container">
  <!-- Include FilterBarComponent -->

  <h2 class="section-title">Best Seller</h2>
  <div class="product-grid">
    <!-- ProductCardComponent -->
  </div>

  <h2 class="section-title">New Products</h2>
  <div class="product-grid">
    <!-- ProductCardComponent -->
  </div>

  <h2 class="section-title">Shop by Category</h2>
  <div class="category-grid">
    <!-- CategoryCardComponent -->
  </div>
</div>
