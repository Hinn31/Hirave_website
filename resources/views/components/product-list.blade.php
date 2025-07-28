<div class="product-grid">
    @forelse ($products as $product)
        @include('components.product-card', ['product' => $product])
    @empty
        <p>Không có sản phẩm phù hợp.</p>
    @endforelse
</div>
