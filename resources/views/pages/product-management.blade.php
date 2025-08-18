    @extends('layouts.master')
    @section('title', 'Product Management')

    @section('content')
        <link rel="stylesheet" href="{{ asset('css/product-management.css') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="products-management">
        <!-- Sidebar -->
        @include('components.sidebar')
        <!-- Main content -->
        <div class="main">
            <h2>Product management</h2>
            <div class="top-bar">
                <a href="{{route('product-management.create')}}" ><button>Add Product</button></a>
                <div>
                    <input type="text" id="keyword" placeholder="Search Product">
                    <button type="button" onclick="searchProduct()">Search</button>
                </div>
            </div>

            <!-- Table -->
            <table>
                <thead>
                <tr>
                    <th>ID</th>
                    <th style="width: 200px">Product Name</th>
                    <th>Timestamp</th>
                    <th>Category</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Old price</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product )
                        <tr>
                            <td>{{$product->id}}</td>
                            <td>{{$product->productName}}</td>
                            <td>{{ $product->created_at->format('Y-m-d') }}</td>
                            <td>{{$product->categoryID}}</td>
                            <td>{{$product->stock}}</td>
                            <td>{{$product->price}}</td>
                            <td>{{$product->oldPrice}}</td>
                            <td>
                                @if($product->imageURL)
                                    <img src="{{ asset($product->imageURL) }}" alt="{{ $product->productName }}" width="40" height="40">
                                @else
                                    -
                                @endif
                            </td>
                            <td class="actions">
                                <a href="{{ route('product-management.edit', $product->id) }}"><button class="edit">Edit</button></a>
                                <form action="{{ route('product-management.destroy', $product->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="delete" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>

            <!-- Pagination -->
            <div class="pagination">
                {{ $products->links() }}
            </div>

        </div>
    </div>
    <script src="{{ asset('js/search-products.js') }}"></script>
    @endsection
