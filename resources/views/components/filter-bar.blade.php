<link rel="stylesheet" href="{{ asset('css/filter-products.css') }}">

<div class="filter-products">
    <div class="filter-products-nav">
        <!-- Left: Product Categories -->
        <div class="products-nav-left">
            @foreach (['EARRING', 'NECKLACE', 'RING', 'BRACELET'] as $category)
                <div class="dropdown">
                    <a href="#" class="list-item">{{ $category }} <i class="fa-solid fa-angle-down"></i></a>
                    <div class="dropdown-content">
                        <a href="#" class="filter-link" data-category="{{ strtolower($category) }}" data-material="">All</a>
                        <a href="#" class="filter-link" data-category="{{ strtolower($category) }}" data-material="silver">Silver</a>
                        <a href="#" class="filter-link" data-category="{{ strtolower($category) }}" data-material="gold">Gold</a>
                        <a href="#" class="filter-link" data-category="{{ strtolower($category) }}" data-material="platinum">Platinum</a>
                        <a href="#" class="filter-link" data-category="{{ strtolower($category) }}" data-material="titanium">Titanium</a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Right: Sort -->
        <div class="products-nav-right">
            <div class="dropdown">
                <a href="#" class="sort-item active-sort">SORT BY LATEST <i class="fa-solid fa-angle-down icon-gray"></i></a>
                <div class="dropdown-content">
            <a href="#" class="sort-link" data-sort="">Price: All</a>
            <a href="#" class="sort-link" data-sort="price_asc">Price: Low to High</a>
            <a href="#" class="sort-link" data-sort="price_desc">Price: High to Low</a>
        </div>
            </div>
        </div>
    </div>
</div>

<!-- Kết quả lọc -->
<div id="productResults" style="margin-top: 30px;"></div>

<script>
    const baseApiUrl = "{{ url('/api/products/filter') }}";

    document.querySelectorAll('.filter-link').forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();

            const category = this.getAttribute('data-category');
            const material = this.getAttribute('data-material');

            fetch(`${baseApiUrl}?category=${category}&material=${material}`)
                .then(response => response.json())
                .then(data => {
                    const container = document.getElementById('productResults');
                    const defaultSection = document.getElementById('defaultHighlightedProducts');

                    // Ẩn phần sản phẩm mặc định (nếu đang hiển thị)
                    if (defaultSection) {
                        defaultSection.style.display = 'none';
                    }

                    // Chèn HTML trả về từ server (đã render bằng Blade)
                    container.innerHTML = data.html;
                })
                .catch(error => {
                    console.error('Lỗi gọi API:', error);
                    alert('Đã xảy ra lỗi khi tải sản phẩm.');
                });
        });
    });
</script>


