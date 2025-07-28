<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product; // nếu bạn dùng model Product


class ProductController2 extends Controller
{
 public function search(Request $request)
{
    $keyword = $request->input('keyword');

    $is_best_sellers = Product::where('is_best_seller', true)
        ->where('productName', 'like', '%' . $keyword . '%')
        ->get();

    $newProducts = Product::where('is_new_product', true)
        ->where('productName', 'like', '%' . $keyword . '%')
        ->get();


    return view('pages.searchresult', compact(
        'keyword',
        'is_best_sellers',
        'newProducts',
    ));
}
}
