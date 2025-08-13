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
    // GET /product/{id}
    public function show($id) {
        $product = Product::with('category')->findOrFail($id);
        return response()->json([
            'productName' => $product->productName,
            'price' => $product->price,
            'oldPrice' => $product->oldPrice,
            'description' => $product->description,
            'imageUrl' => asset('images/products/' . $product->imageUrl),
            'stock' => $product->stock,
            'categoryName' => $product->category->categoryName ?? '',
        ]);
    }

    // GET product detail page
    public function productDetail($id) {
        $product = Product::with('category')->findOrFail($id);

        $relatedProducts = Product::where('categoryID', $product->categoryID)
                                  ->where('id', '!=', $product->id)
                                  ->take(4)
                                  ->get();

        $reviews = Review::with('user')
                         ->where('productID', $id)
                         ->orderBy('reviewDate', 'desc')
                         ->get();

        return view('pages.product-detail', compact('product', 'relatedProducts', 'reviews'));
    }

    // Store a new review
    public function store(Request $request)
    {
        $request->validate([
            'productID' => 'required|integer|exists:products,id',
            'comment' => 'required|string|max:1000',
            'rating' => 'required|integer|min:1|max:5'
        ]);

        if (!Auth::check()) {
            return response()->json(['message' => 'You are not logged in.'], 401);
        }

        $review = Review::create([
            'rating' => $request->rating,
            'comment' => $request->comment,
            'userID' => Auth::id(),
            'productID' => $request->productID,
        ])->load('user');

        // Render the review component and return HTML
        $html = view('components.customer-review', [
            'reviews' => [$review]
        ])->render();

        return response()->json([
            'message' => 'Review has been successfully added.',
            'html' => $html
        ]);
    }
}
