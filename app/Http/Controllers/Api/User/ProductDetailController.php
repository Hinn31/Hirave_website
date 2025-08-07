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
        // $reviews = $products->reviews()->with('user')->orderBy('reviewDate', 'desc')->get();
        $reviews = Review::with('user')->where('productID', $id)->orderBy('reviewDate', 'desc')->get();
        
        return view('pages.product-detail', compact('products', 'relatedProducts', 'reviews'));
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'product_id' => 'required|exists:products,id',
    //         'name' => 'required|string|max:50',
    //         'email' => 'required|email',
    //         'comment' => 'required|string|max:1000',
    //     ]);

    //     $user = User::firstOrCreate(
    //         ['email' => $request->email],
    //         ['fullname' => $request->name, 'username' => uniqid(), 'password' => bcrypt('12345678')]
    //     );

    //     Review::create([
    //         'userID' => $user->id,
    //         'productID' => $request->product_id,
    //         'comment' => $request->comment,
    //         'reviewDate' => now(),
    //     ]);

    //     return back()->with('success', 'Your comment has been posted!');
    // }

     public function postReview(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|max:500',
        ]);

        // Tạo bình luận mới
        $review = new Review();
        $review->productID = $id;
        $review->userID = Auth::id(); // Lưu id người dùng
        $review->comment = $request->comment;
        $review->save();

        return back()->with('success', 'Bình luận đã được thêm!');
    }
}
