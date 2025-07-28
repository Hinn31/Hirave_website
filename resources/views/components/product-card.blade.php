<head>
    <link rel="stylesheet" href="{{ asset('css/product_card.css') }}">
    <style>
        .product-badge {
            position: absolute;
            top: 8px;
            left: 8px;
            background-color: red;
            color: white;
            font-size: 12px;
            padding: 2px 6px;
            border-radius: 4px;
            text-transform: uppercase;
        }

        .product-badge.new {
            background-color: green;
        }

        .product-image {
            position: relative;
        }
    </style>
</head>

<div class="product-grid">
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
