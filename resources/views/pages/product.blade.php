@extends('layouts.master')

@section('title', 'Sản phẩm - Hivera')

@section('content')
<div class="container">
    @include('components.filter-bar')
@php
    $highlightedProducts = $is_best_sellers->merge($newProducts)->unique('id');
@endphp

<div id="defaultHighlightedProducts">
    <section class="highlighted-products">
        <div class="product-grid">
            @foreach($highlightedProducts as $product)
                @include('components.product-card', ['product' => $product])
            @endforeach
        </div>
    </section>
</div>

@if($categories->count() > 0)
    <section class="categories" id="defaultCategories">
        <h2 class="section-title">Shop Category</h2>
        <div class="category-grid">
            @foreach($categories as $category)
                @include('components.category-card', [
                    'name' => $category->categoryName,
                    'image' => asset('images/category/' . $category->image)
                ])
            @endforeach
        </div>
    </section>
@endif
</div>
@endsection
