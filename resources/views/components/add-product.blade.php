<link rel="stylesheet" href="{{ asset('css/products-management.css') }}">
<div class="product-form">
    <h3 id="form-title">{{ isset($product) ? 'Edit Product' : 'Add Product' }}</h3>

    <form
        id="productForm"
        action="{{ isset($product) ? route('products-management.update', $product->id) : route('products-management.store') }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf
        @if(isset($product))
            @method('PUT')
        @endif

        <!-- Product Name -->
        <div class="form-group">
            <label for="productName">Product Name</label>
            <input type="text" id="productName" name="productName"
                value="{{ old('productName', $product->productName ?? '') }}"
                placeholder="Enter product name" required>
        </div>

        <!-- Description -->
        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="3" placeholder="Enter product description">{{ old('description', $product->description ?? '') }}</textarea>
        </div>

        <!-- Category -->
        <div class="form-group">
            <label for="categoryID">Category</label>
            <select id="categoryID" name="categoryID" required>
                <option value="">-- Select category --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ old('categoryID', $product->categoryID ?? '') == $category->id ? 'selected' : '' }}>
                        {{ $category->categoryName }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Stock (Quantity) -->
        <div class="form-group">
            <label for="stock">Quantity</label>
            <input type="number" id="stock" name="stock"
                value="{{ old('stock', $product->stock ?? 0) }}"
                min="0">
        </div>

        <!-- Price -->
        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" id="price" name="price"
                value="{{ old('price', $product->price ?? '') }}"
                min="0" placeholder="Enter price" required>
        </div>

        <!-- Old Price -->
        <div class="form-group">
            <label for="oldPrice">Old Price</label>
            <input type="number" id="oldPrice" name="oldPrice"
                value="{{ old('oldPrice', $product->oldPrice ?? '') }}"
                min="0" placeholder="Enter old price">
        </div>

        <!-- Material -->
        <div class="form-group">
            <label for="material">Material</label>
            <input type="text" id="material" name="material"
                value="{{ old('material', $product->material ?? '') }}"
                maxlength="50" placeholder="Enter material (e.g. wood, metal)">
        </div>

        <!-- Product Image -->
        <div class="form-group">
            <label for="imageURL">Product Image</label>
            <input type="file" id="imageURL" name="imageURL">
            @if(isset($product) && $product->imageURL)
                <div class="current-image">
                    <small>Current:
                        <img src="{{ asset($product->imageURL) }}" alt="Product" width="80">
                    </small>
                </div>
            @endif
        </div>

        <!-- Is Best Seller -->
        <div class="form-group">
            <label for="is_best_seller">Best Seller</label>
            <select id="is_best_seller" name="is_best_seller" required>
                <option value="1" {{ old('is_best_seller', $product->is_best_seller ?? 0) == 1 ? 'selected' : '' }}>1</option>
                <option value="0" {{ old('is_best_seller', $product->is_best_seller ?? 0) == 0 ? 'selected' : '' }}>0</option>
            </select>
        </div>

        <!-- Is New Product -->
        <div class="form-group">
            <label for="is_new_product">New Product</label>
            <select id="is_new_product" name="is_new_product" required>
                <option value="1" {{ old('is_new_product', $product->is_new_product ?? 0) == 1 ? 'selected' : '' }}>1</option>
                <option value="0" {{ old('is_new_product', $product->is_new_product ?? 0) == 0 ? 'selected' : '' }}>0</option>
            </select>
        </div>

        <!-- Actions -->
        <div class="form-actions">
            <button type="submit" class="btn save" id="submitBtn">{{ isset($product) ? 'Update' : 'Save' }}</button>
            <a href="{{ route('products-management.index') }}" class="btn cancel">Cancel</a>
        </div>
    </form>
</div>
