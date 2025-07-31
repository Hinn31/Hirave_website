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
            'oldPrice' => $products->oldPrice,
            'description' => $products->description,
            'imageUrl' => $products->imageUrl,
            'stock' => $products->stock,
            'categoryName' => $products->category->categoryName ?? '',
        ]);
    }

    //GET PRODUCT TO DISPLAY INTO PRODUCT DETAIL
    public function productDetail($id) {
    $product = Product::with('category')->findOrFail($id);

    $relatedProducts = Product::where('categoryID', $product->categoryID)
                              ->where('id', '!=', $product->id)
                              ->take(4)
                              ->get();

    return view('pages.product-detail', compact('product', 'relatedProducts'));
}


}
