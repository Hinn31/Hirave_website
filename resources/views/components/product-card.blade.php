<head>
    <link rel="stylesheet" href="{{ asset('css/product_card.css') }}">
</head>

<div class="product-grid">
<a href="{{ url('/product/' . $product->id) }}">
    <div class="product-card">
        <div class="product-image">
            <img src="{{ asset('images/products/' . $product->imageURL) }}" alt="{{ $product->productName }}">

            @if ($product->is_best_seller)
                <div class="product-badge">Hot</div>
            @endif

            @if ($product->is_new_product)
                <div class="product-badge new">New</div>
            @endif
        </div>

        <div class="product-info">
            <h4 class="product-name">{{ $product->productName }}</h4>

            <div class="product-price">
                <span class="price-sale">${{ number_format($product->price, 2) }}</span>
                @if ($product->oldPrice)
                    <span class="price-original">${{ number_format($product->oldPrice, 2) }}</span>
                @endif
            </div>
        </div>
    </div>
</div>
