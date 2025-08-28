
<link rel="stylesheet" href="{{ asset('css/product-card-mini.css') }}">

@foreach ($products as $product)
    <div class="product-card-mini" data-id="{{ $product->id }}" id="product-card-mini">
     <img src="{{ asset( $product->imageURL) }}"
     alt="{{ $product->name }}"
     class="product-card__image">
    </div>
@endforeach

