<?php

namespace App\Http\Controllers\Api\User;;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
            'imageUrl' => asset('images/products/' . $products->imageUrl),
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
        // $reviews = $products->reviews()->with('user')->orderBy('reviewDate', 'desc')->get();
        $reviews = Review::with('user')->where('productID', $id)->orderBy('reviewDate', 'desc')->get();
    return view('pages.product-detail', compact('product', 'relatedProducts', 'reviews'));

    }


    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'comment'    => 'required|string|max:1000',
        ]);

        $review = Review::create([
            'user_id'    => $request->user()->id,
            'product_id' => $request->product_id,
            'comment'    => $request->comment,
        ]);

        return response()->json([
            'message' => 'Review added successfully',
            'review'  => $review
        ]);
    }
    //  public function postReview(Request $request, $id)
    // {
    //     $request->validate([
    //         'comment' => 'required|max:500',
    //     ]);

    //     // Tạo bình luận mới
    //     $review = new Review();
    //     $review->productID = $id;
    //     $review->userID = Auth::id(); // Lưu id người dùng
    //     $review->comment = $request->comment;
    //     $review->save();

    //     return back()->with('success', 'Bình luận đã được thêm!');
    // }
}
