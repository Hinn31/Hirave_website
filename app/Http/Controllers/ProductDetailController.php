<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Reviews;

class ProductDetailController extends Controller
{
    //GET /PRODUCT/ID
    public function show($id) {
        $products = Products::with('categories')->findOrFail($id);
        return response()->json([
            'productName'=>$products->productName,
            'price' => $products->price,
            'description' => $products->description,
            'imageUrl' => $products->imageUrl,
            'stock' => $products->stock,
            'categoryName' => $products->categories->categoryName ?? '',
        ]);
    }

    //GET PRODUCT TO DISPLAY INTO PRODUCT DETAIL
    public function productDetail($id) {
        $products = Products::with('categories')->findOrFail($id);
        $relatedProducts = Products::where('categoryID', $products->categoryID)
                                ->where('id', '!=', $products->id)
                                ->take(4)
                                ->get();
            return view('pages.product-detail', compact('products', 'relatedProducts'));
    }

}
