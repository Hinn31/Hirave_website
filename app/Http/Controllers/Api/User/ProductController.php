<?php

namespace App\Http\Controllers\Api\User;
use App\Http\Controllers\Controller; // ✅ dòng này để kế thừa Controller gốc
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    // Lấy danh sách tất cả sản phẩm
    public function index()
    {
        return response()->json(Product::all(), 200);
    }

    // Tạo sản phẩm mới
    public function store(Request $request)
    {
    $validated = $request->validate([
        'productName' => 'required|string|max:100',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'oldPrice' => 'nullable|numeric|min:0',
        'imageURL' => 'nullable|string|max:255',
        'stock' => 'required|integer|min:0',
        'categoryID' => 'required|exists:categories,id',
        'is_best_seller' => 'required|boolean',
        'is_new_product' => 'required|boolean',
    ]);

        $product = Product::create($validated);

        return response()->json([
            'message' => 'Product created successfully!',
            'product' => $product
        ], 201);
    }

    // Hiển thị chi tiết một sản phẩm
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return response()->json($product);
    }

    public function showView($id)
{
    $product = Product::findOrFail($id);
    return view('product.show', compact('product'));
}


    // Cập nhật sản phẩm
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'productName' => 'required|string|max:100',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'oldPrice' => 'nullable|numeric|min:0',
            'imageURL' => 'nullable|string|max:255',
            'stock' => 'required|integer|min:0',
            'categoryID' => 'required|exists:categories,id',
            'is_best_seller' => 'required|boolean',
            'is_new_product' => 'required|boolean',

        ]);

        $product->update($validated);

        return response()->json([
            'message' => 'Product updated successfully!',
            'product' => $product
        ]);
    }

    // Xóa sản phẩm
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json(['message' => 'Product deleted successfully!']);
    }
    public function productPage()
{
    $is_best_sellers = Product::where('is_best_seller', true)->get();

    $newProducts = Product::where('is_new_product', true)->get();

    $categories = Category::all();

   return view('pages.product',[
        'is_best_sellers' => $is_best_sellers,
        'newProducts' => $newProducts,
        'categories' => $categories,
    ]);
}
}
