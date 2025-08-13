@props(['products'])

<link rel="stylesheet" href="{{ asset('css/product-card-mini.css') }}">

@foreach ($products as $product)
    <div class="product-card-mini" data-id="{{ $product->id }}" id="product-card-mini">
        <img src="{{asset($product->imageURL)}}" alt="Image" class="product-card__image">
        <span class="product-card__badge">HOT</span>
    </div>
<<<<<<< HEAD
@endforeach
@endforeach
=======
@endforeach
>>>>>>> 57f90e3fb06d35415de11faedf2ccf985dbcb4e5
