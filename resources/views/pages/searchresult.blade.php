@extends('layouts.master')

@section('content')
    <div style="padding: 20px;">
    @php
    $highlightedProducts = $is_best_sellers->merge($newProducts)->unique('id');
@endphp

@if($highlightedProducts->count() > 0)
    <section class="highlighted-products" id="defaultHighlightedProducts">
        <div class="product-grid">
            @foreach($highlightedProducts as $product)
                @include('components.product-card', ['product' => $product])
            @endforeach
        </div>
    </section>
@endif

    @if($is_best_sellers->isEmpty() && $newProducts->isEmpty())
        <p>Không có sản phẩm nào để hiển thị.</p>
    @endif
    </div>
@endsection
