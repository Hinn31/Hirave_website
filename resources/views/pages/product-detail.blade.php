@extends('layouts.app')
@section('title', 'Product Detail')
@section('content')

<div class="product-detail">
    <div class="product-detail__top">
        <div class="product-detail__image">
            <img src="https://bacminhcanh.com/wp-content/uploads/2018/12/lac-tay-bac-nu-sao-day-doi-156-2.jpg" alt="">
        </div>

        <div class="product-detail__info">
            <h1 class="product-title">Silver shake silver star double strap ltnu123</h1>

            <div class="product-price">
                <span class="product-price__current">$69.75</span>
                <span class="product-price__original">$139.75</span>
            </div>

            <div class="product-stock">
                Stock: <span class="product-stock__value">99 in stock</span>
            </div>

            <div class="product-action">
                <div class="product-action__row">
                    <div class="qty-box">
                    <button class="qty-btn qty-btn__minus">-</button>
                    <input type="number" class="qty-input" value="1" min="1">
                    <button class="qty-btn qty-btn__plus">+</button>
                    </div>
                    <button class="btn btn-black">Add to cart</button>
                </div>
                <button class="btn btn-gray">Buy Now</button>
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
                    These gold-plated hoops are sure to add a touch of glamour to your evening look.
                    Designed to hug the ears, they’re a sure snug fit, finished with pretty pearls swinging off the base.
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit...
                </p>
            </div>

            <!-- Review -->
            <div class="tab-pane" data-tab="review">
                <h3 class="review-title">Customers reviews</h3>
                <div class="review-list">
                    <div class="review-item">
                        <img src="https://banobagi.vn/wp-content/uploads/2025/05/hinh-anh-anime-nu-11.jpeg" alt="">
                        <div class="review-info">
                            <strong>Jenna S.</strong>
                            <small>Mar 15, 2021</small>
                            <p class="review-text">Very nice product.<br>Everything is perfect. I would recommend!</p>
                        </div>
                    </div>

                    <div class="review-item">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQaa1vgMmdGI7ouFqsIsh-CJq3lSFL5fHD3kXK_WSd9-ngNZXE0eGDUD5qJAR_7vtd1beY&usqp=CAU" alt="">
                        <div class="review-info">
                            <strong>Jenna S.</strong>
                            <small>Mar 15, 2021</small>
                            <p class="review-text">Very nice product.<br>Everything is perfect. I would recommend!</p>
                        </div>
                    </div>
                </div>

                <h3 class="review-title">Add a review</h3>
                <p class="review-description">Your email address will not be published. Required fields are marked *</p>

                <form class="review-form">
                    <textarea placeholder="Your review" required></textarea>
                    <div class="review-form__row">
                        <input type="text" placeholder="Name" required>
                        <input type="email" placeholder="Email" required>
                    </div>
                    <button type="submit" class="btn btn-black">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <div class="related-products">
        <h2 class="related-title">Related products</h2>
        <div class="related-list">
            <div class="related-item">
                <img src="https://tittac.com/images/thumbs/0017992_mulany-mbk8001-natural-stone-with-silver-charm-kids-healing-bracelet.jpeg" alt="">
                <span class="hot-badge">HOT</span>
            </div>
            <div class="related-item">
                <img src="https://tittac.com/images/thumbs/0017992_mulany-mbk8001-natural-stone-with-silver-charm-kids-healing-bracelet.jpeg" alt="">
                <span class="hot-badge">HOT</span>
            </div>
            <div class="related-item">
                <img src="https://tittac.com/images/thumbs/0017992_mulany-mbk8001-natural-stone-with-silver-charm-kids-healing-bracelet.jpeg" alt="">
                <span class="hot-badge">HOT</span>
            </div>
            <div class="related-item">
                <img src="https://tittac.com/images/thumbs/0017992_mulany-mbk8001-natural-stone-with-silver-charm-kids-healing-bracelet.jpeg" alt="">
                <span class="hot-badge">HOT</span>
            </div>
        </div>
    </div>
</div>

<script>
    const tabs = document.querySelectorAll(".tab");
    const panes = document.querySelectorAll(".tab-pane");

    tabs.forEach((tab, index) => {
        tab.addEventListener("click", () => {
            tabs.forEach(t => t.classList.remove("active"));
            panes.forEach(p => p.classList.remove("active"));
            tab.classList.add("active");
            panes[index].classList.add("active");
        });
    });
</script>
@endsection
