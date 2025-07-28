<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductFilterController extends Controller
{
    public function filter(Request $request)
    {
        $query = Product::with('category');

        // Lọc theo danh mục
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('categoryName', $request->category);
            });
        }

        // Lọc theo khoảng giá
        if ($request->filled('price')) {
            $range = explode('-', $request->price);
            if (count($range) === 2) {
                $query->whereBetween('price', [(int)$range[0], (int)$range[1]]);
            }
        }

        // Lọc theo chất liệu
        if ($request->filled('material')) {
            $query->where('material', $request->material);
        }

        // Sắp xếp
        if ($request->filled('sort')) {
            if ($request->sort === 'price_asc') {
                $query->orderBy('price', 'asc');
            } elseif ($request->sort === 'price_desc') {
                $query->orderBy('price', 'desc');
            }
        }

        // Lấy danh sách sản phẩm
        $products = $query->get();

        // Render Blade component và trả về HTML
        $html = view('components.product-list', compact('products'))->render(); 

        return response()->json(['html' => $html]);
    }
}
