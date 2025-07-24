@extends('layouts.master')

@section('title', 'Sản phẩm - Hivera')

@section('content')
<div class="container">
    <!-- Filter Bar -->
    @include('components.filter-bar')

    <!-- Best Sellers Section -->
    @if($is_best_sellers->count() > 0)
        <section class="best-sellers">
            <h2 class="section-title">Best Seller</h2>
            <div class="product-grid">
                @foreach($is_best_sellers as $product)
                    @include('components.product-card', ['product' => $product])
                @endforeach
            </div>
        </section>
    @endif

    <!-- New Products Section -->
    @if($newProducts->count() > 0)
        <section class="new-products">
            <h2 class="section-title"> New Product</h2>
            <div class="product-grid">
                @foreach($newProducts as $product)
                    @include('components.product-card', ['product' => $product])
                @endforeach
            </div>
        </section>
    @endif

    @if($categories->count() > 0)
            <section class="categories">
                <h2 class="section-title">🛍️ Shop Category</h2>
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
    <!-- Thông báo khi không có sản phẩm -->
    @if($is_best_sellers->isEmpty() && $newProducts->isEmpty())
        <p>Không có sản phẩm nào để hiển thị.</p>
    @endif
</div>
@endsection
