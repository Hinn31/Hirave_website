@extends('layouts.master')
@section('title', 'Product Detail')
@section('content')
<link rel="stylesheet" href="{{ asset('css/product-detail.css') }}">

<div class="back-button" style="margin-bottom: 20px;">
    <a href="{{ route('product.page') }}" class="btn btn-back" style="text-decoration: none; color: #333;">
        <i class="fas fa-arrow-left"></i>
    </a>
</div>
<div class="product-detail">
    <div class="product-detail__top">
        <div class="product-detail__image">
            {{-- <img src="{{ asset($product->imageURL) }}" alt="Image"> --}}
            <img src="{{ asset('images/products/' . $product->imageURL) }}" alt="{{ $product->productName }}">
        </div>
        <div class="product-detail__info">
            <h1 class="product-title">{{ $product->productName }}</h1>
            <div class="product-price">
                <span class="product-price__current">${{ number_format($product->price, 2) }}</span>
                <span class="product-price__original">${{ number_format($product->oldPrice,2) }}</span>
            </div>

            <div class="product-stock">
                Stock: <span class="product-stock__value">{{ $product->stock }}</span>
            </div>

            <div class="product-action">
                <div class="product-action__row">
                    <div class="qty-box">
                        <button class="qty-btn qty-btn__minus">-</button>
                        <input type="number" class="qty-input" value="1" min="1" data-stock="{{ $product->stock }}">
                        <button class="qty-btn qty-btn__plus">+</button>
                    </div>
                    <button class="btn btn-add-to-card">Add to cart</button>
                </div>
                <button class="btn btn-buy">Buy Now</button>
            </div>

            <div class="product-total">
                Total: <span id="totalPrice">${{ number_format($product->price, 2) }}</span>
            </div>
        </div>
    </div>

    <div class="product-detail-tabs">
        <div class="tabs">
            <button class="tab active">Description</button>
            <button class="tab">Review</button>
        </div>
        <div class="tab-content">
            <div class="tab-pane active" data-tab="description">
                <p class="product-description">
                    {{ $product->description }}
                </p>
            </div>

            <div class="tab-pane" data-tab="review">
                <h3 class="review-title">Customers reviews</h3>
                <div class="review-list">
                    @include('components.customer-review')
                </div>

                <h3 class="review-title">Add a review</h3>
                <p class="review-description">Your email address will not be published. Required fields are marked *</p>

                <form id="reviewForm" class="review-form">
                    @csrf
                    <input type="hidden" id="product_id" name="product_id" value="{{ $product->id }}">
                    <textarea id="comment" name="comment" placeholder="Your review" required></textarea>

                    <div class="review-form__row">
                        <input type="text" name="name" placeholder="Name" required id="name">
                        <input type="email" name="email" placeholder="Email" required id="email">
                    </div>
                    <button type="submit" class="btn btn-submit">Submit</button>
                </form>

                <p id="reviewMessage" style="margin-top: 10px; color: green;"></p>

            </div>
        </div>
    </div>

    {{-- Related product --}}
    <div class="related-products">
        <h2 class="related-title">Related products</h2>
        <div class="related-list">
            @include('components.product-card-mini', ['products' => $relatedProducts])
        </div>
    </div>
</div>

{{-- <script  src="{{ asset('js/auth.js') }}"></script> --}}
<script type="module" src="{{ asset('js/product-detail.js') }}"></script>
@endsection
