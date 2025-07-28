<?php

namespace App\Http\Controllers\Api\User;;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductDetailController extends Controller
{
    //GET /PRODUCT/ID
    public function show($id) {
        $products = Product::with('category')->findOrFail($id);
        return response()->json([
            'productName'=>$products->productName,
            'price' => $products->price,
            'description' => $products->description,
            'imageUrl' => $products->imageUrl,
            'stock' => $products->stock,
            'categoryName' => $products->category->categoryName ?? '',
        ]);
    }

    //GET PRODUCT TO DISPLAY INTO PRODUCT DETAIL
    public function productDetail($id) {
        $products = Product::with('category')->findOrFail($id);
        $relatedProducts = Product::where('categoryID', $products->categoryID)
                                ->where('id', '!=', $products->id)
                                ->take(4)
                                ->get();
            return view('pages.product-detail', compact('products', 'relatedProducts'));
    }

}
