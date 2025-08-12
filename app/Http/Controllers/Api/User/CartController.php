<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Thêm sản phẩm vào giỏ hàng
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'nullable|integer|min:1'
        ]);

        $quantity = $request->quantity ?? 1;
        $user = Auth::user();

        // Lấy hoặc tạo giỏ hàng cho user
        $cart = Cart::firstOrCreate(['userID' => $user->id]);

        // Kiểm tra nếu sản phẩm đã tồn tại trong giỏ hàng
        $item = CartItem::where('cartID', $cart->id)
                        ->where('productID', $request->product_id)
                        ->first();

        if ($item) {
            $item->quantity += $quantity;
            $item->save();
        } else {
            CartItem::create([
                'cartID'    => $cart->id,
                'productID' => $request->product_id,
                'quantity'  => $quantity
            ]);
        }

        return response()->json([
            'message' => 'Đã thêm sản phẩm vào giỏ hàng',
            'cart_count' => $cart->items()->sum('quantity')
        ]);
    }

    // Lấy giỏ hàng
    public function showCart()
    {
        $user = Auth::user();
        $cart = Cart::with('items.product')->where('userID', $user->id)->first();

        return response()->json([
            'cart' => $cart ? $cart->items->map(function ($item) {
                return [
                    'id'       => $item->product->id,
                    'name'     => $item->product->productName,
                    'price'    => $item->product->price,
                    'quantity' => $item->quantity,
                    'imageURL' => $item->product->imageURL
                ];
            }) : [],
            'cart_count' => $cart ? $cart->items->sum('quantity') : 0
        ]);
    }

    // Cập nhật số lượng
    public function updateCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1'
        ]);

        $user = Auth::user();
        $cart = Cart::where('userID', $user->id)->first();

        if (!$cart) {
            return response()->json(['error' => 'Giỏ hàng trống'], 404);
        }

        $item = CartItem::where('cartID', $cart->id)
                        ->where('productID', $request->product_id)
                        ->first();

        if (!$item) {
            return response()->json(['error' => 'Sản phẩm không có trong giỏ hàng'], 404);
        }

        $item->quantity = $request->quantity;
        $item->save();

        return response()->json([
            'message' => 'Cập nhật giỏ hàng thành công',
            'cart_count' => $cart->items()->sum('quantity')
        ]);
    }

    // Xóa sản phẩm
    public function removeFromCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $user = Auth::user();
        $cart = Cart::where('userID', $user->id)->first();

        if (!$cart) {
            return response()->json(['error' => 'Giỏ hàng trống'], 404);
        }

        CartItem::where('cartID', $cart->id)
                ->where('productID', $request->product_id)
                ->delete();

        return response()->json([
            'message' => 'Đã xóa sản phẩm khỏi giỏ hàng',
            'cart_count' => $cart->items()->sum('quantity')
        ]);
        
    }
    
}
