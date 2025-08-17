<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductManagementController extends Controller
{
    //Hiển thị all sản phẩm
    public function index() {
        $products = Product::paginate(8);
        return view('pages.products-management', compact('products'));
    }

    // Thêm sản phẩm mới
    public function create() {
        $categories = Category::all();
        return view('components.add-product', compact('categories'));
    }

    // Lưu sản phẩm mới
    public function store(Request $request) {
        $validated = $request->validate([
            'productName' => 'required|string|max:100',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'oldPrice' => 'nullable|numeric|min:0',
            'imageURL' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'stock' => 'required|integer|min:0',
            'material' => 'nullable|string|max:50',
            'categoryID' => 'required|exists:categories,id',
            'is_best_seller' => 'required|boolean',
            'is_new_product' => 'required|boolean',

        ]);

        if ($request->hasFile('imageURL')) {
            $file = $request->file('imageURL');
            $filename = time() . '-' . $file->getClientOriginalName();
            $path = $file->move(public_path('images/products'), $filename);

            // Chỉ lưu đường dẫn tương đối
            $validated['imageURL'] = 'images/products/' . $filename;
        }

        Product::create($validated);
        return redirect()->route('products-management.index')
            ->with('success', 'Add product successfully!');

    }

    // Form sửa sản phẩm
    public function edit($id) {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('components.add-product', compact('product', 'categories'));
    }

    // Cập nhật sản phẩm
    public function update(Request $request, $id) {
        $product = Product::findOrFail($id);
        $validated = $request->validate([
            'productName' => 'required|string|max:100',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'oldPrice' => 'nullable|numeric|min:0',
            'imageURL' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'stock' => 'required|integer|min:0',
            'material' => 'nullable|string|max:50',
            'categoryID' => 'required|exists:categories,id',
            'is_best_seller' => 'required|boolean',
            'is_new_product' => 'required|boolean',

        ]);
        if ($request->hasFile('imageURL')) {
            $file = $request->file('imageURL');
            $filename = time() . '-' . $file->getClientOriginalName();
            $path = $file->move(public_path('images/products'), $filename);

            // Chỉ lưu đường dẫn tương đối
            $validated['imageURL'] = 'images/products/' . $filename;
        }

            $product->update($validated);
        return redirect()->route('products-management.index')
            ->with('success', 'Product updated successfully!');

    }

    // Xóa sản phẩm
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products-management.index')
            ->with('success', 'Product deleted successfully!');
    }

    // Tìm kiếm sản phẩm
    public function search(Request $request) {
        $keyword = $request->input('keyword');
        $products = Product::where('productName', 'like', "%{$keyword}%")->get();
        return response()->json($products);
    }

}
