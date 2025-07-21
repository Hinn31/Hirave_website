@extends('layouts.app')
@section('title', 'Product Detail')
@section('content')

<div class="product-detail">
    <div class="product-detail__top">
        <div class="product-detail__image">
            <img src="https://bacminhcanh.com/wp-content/uploads/2018/12/lac-tay-bac-nu-sao-day-doi-156-2.jpg" alt="">
        </div>
        {{-- <div class="product-detail-right">
            <h4 class="product-name">Silver shake silver star double strap ltnu123</h4>
            <div class="price-stock">
                <div class="product-price">
                    <span class="new-price">$50</span>
                    <span class="old-price">$100</span>
                </div>
                <div class="product-stock">
                    <span>Stock: <p class="hightlight">100 in stock</p></span>
                </div>
            </div>
            <div class="btn-active">
                <div class="btn-qantity-cart">
                    <div class="btn-quantity">
                        <button class="btn-minus">-</button>
                        <input type="number" value="1" class="input-qantity">
                        <button class="btn-plus">+</button>
                    </div>
                    <button class="btn-cart">Add to cart</button>
                </div>
                <button class="btn-buy">BUY NOW</button>
            </div>
        </div> --}}
        <div class="product-detail__info">
      <h1 class="product-title">Pearl Drop Stud Set of Two</h1>

      <div class="product-price">
        <span class="product-price__current">$69.75</span>
        <span class="product-price__original">$139.75</span>
      </div>

      <div class="product-stock">
        Stock: <span class="product-stock__value">99 in stock</span>
      </div>

      <div class="product-action">
        <div class="product-action__row">
          <button class="qty-btn qty-btn__minus">−</button>
          <input type="number" class="qty-input" value="1" min="1">
          <button class="qty-btn qty-btn__plus">+</button>
          <button class="btn btn-black">Add to cart</button>
        </div>
        <button class="btn btn-gray">Buy Now</button>
      </div>
    </div>

    </div>
    <div class="product-detail-meddium">

    </div>
    <div class="product-detail-bottom">

    </div>

</div>
