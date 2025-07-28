@extends('layouts.app')
@section('title', 'Product Detail')
@section('content')

<div class="product-detail">
    <div class="product-detail__top">
        <div class="product-detail__image">
            <img src="{{ $products->imageURL }}" alt="Image">
        </div>

        <div class="product-detail__info">
            <h1 class="product-title">{{ $products->productName }}</h1>

            <div class="product-price">
                <span class="product-price__current">{{ $products->price }}</span>
                <span class="product-price__original">$139.75</span>
            </div>

            <div class="product-stock">
                Stock: <span class="product-stock__value">{{ $products->stock }}</span>
            </div>

            <div class="product-action">
                <div class="product-action__row">
                    <div class="qty-box">
                    <button class="qty-btn qty-btn__minus">-</button>
                    <input type="number" class="qty-input" value="1" min="1"  data-stock="{{ $products->stock }}">
                    <button class="qty-btn qty-btn__plus">+</button>
                    </div>
                    <button class="btn btn-add-to-card">Add to cart</button>
                </div>
                <button class="btn btn-buy">Buy Now</button>
                </div>
        </div>
    </div>

    <div class="product-detail-tabs">
        <div class="tabs">
            <button class="tab active">Description</button>
            <button class="tab">Review</button>
        </div>
        <div class="tab-content">
            <!-- Description -->
            <div class="tab-pane active" data-tab="description">
                <p class="product-description">
                    {{ $products->description }}
                </p>
            </div>

            <!-- Review -->
            <div class="tab-pane" data-tab="review">
                <h3 class="review-title">Customers reviews</h3>
                <div class="review-list">
                    @foreach ($products->reviews as $review)
                        <div class="review-item">
                            <img src="https://banobagi.vn/wp-content/uploads/2025/05/hinh-anh-anime-nu-11.jpeg" alt="">
                            <div class="review-info">
                                <strong>{{ $review->user->fullname ?? 'Anonymous' }}</strong>
                                {{-- <small>{{ $review->reviewDate }}</small> --}}
                                <small>{{ \Carbon\Carbon::parse($review->reviewDate)->format('d M Y') }}</small>
                                <p class="review-text">{{ $review->comment }}</p>
                            </div>
                        </div>
                    @endforeach

                    {{-- <div class="review-item">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQaa1vgMmdGI7ouFqsIsh-CJq3lSFL5fHD3kXK_WSd9-ngNZXE0eGDUD5qJAR_7vtd1beY&usqp=CAU" alt="">
                        <div class="review-info">
                            <strong>Jenna S.</strong>
                            <small>Mar 15, 2021</small>
                            <p class="review-text">Very nice product.<br>Everything is perfect. I would recommend!</p>
                        </div>
                    </div> --}}
                </div>

                <h3 class="review-title">Add a review</h3>
                <p class="review-description">Your email address will not be published. Required fields are marked *</p>

                {{-- <form class="review-form" method="POST" action="{{route('product.reviews', $products->id)}}">
                    @csrf
                    <textarea placeholder="Your review" required></textarea>
                    <div class="review-form__row">
                        <input type="text" name="name" placeholder="Name" required>
                        <input type="email" name="email" placeholder="Email" required>
                    </div>
                    <button type="submit" class="btn btn-submit">Submit</button>
                </form> --}}
                @auth
                    <form class="review-form" method="POST" action="{{ route('product.reviews', $products->id) }}">
                        @csrf
                        <textarea name="comment" placeholder="Your review" required></textarea>

                        <input type="hidden" name="userID" value="{{ auth()->user()->id }}">

                        <div class="review-form__row">
                            <input type="text" name="name" value="{{ auth()->user()->fullname }}" placeholder="Name" required>
                            <input type="email" name="email" value="{{ auth()->user()->email }}" placeholder="Email" required>
                        </div>

                        <button type="submit" class="btn btn-submit">Submit</button>
                    </form>
                @else
                    <p>Bạn cần <a href="{{ route('login') }}">đăng nhập</a> để gửi bình luận.</p>
                @endauth
            </div>
        </div>
    </div>

    <div class="related-products">
        <h2 class="related-title">Related products</h2>
        <div class="related-list">
            @foreach ($relatedProducts as $product)
                <div class="related-item" data-id="{{ $product->id }}">
                    <img src="{{$product->imageURL}}" alt="Image">
                    <span class="hot-badge">HOT</span>
                </div>

            @endforeach
        </div>
    </div>
</div>
    <script src="{{ asset('js/product-detail.js') }}"></script>
@endsection
