<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    // GET /payment
    public function getPaymentData(Request $request)
    {
        $user = $request->user();
        $cart = Cart::with('items.product')->where('userID', $user->id)->first();

        return response()->json([
            'user' => $user,
            'cart' => $cart
        ]);
    }

    // POST /api/payment
public function store(Request $request)
{
    $request->validate([
        'name'           => 'required|string|max:100',
        'phone'          => 'required|string|max:15',
        'city'           => 'required|string|max:100',
        'address'        => 'required|string|max:200',
        'payment_method' => 'required|in:cash,momo,vnpay',
    ]);

    $user = Auth::user();
    $cart = Cart::with('items.product')->where('userID', $user->id)->first();

    if (!$cart || $cart->items->isEmpty()) {
        return response()->json(['error' => 'Giỏ hàng trống'], 400);
    }

    $selectedItems = $request->input('selected_items', []);
    $cartItems = $cart->items;

    if (!empty($selectedItems)) {
        $cartItems = $cartItems->filter(function ($item) use ($selectedItems) {
            return in_array((string)$item->productID, $selectedItems);
        });
    }

    if ($cartItems->isEmpty()) {
        return response()->json(['error' => 'Không có sản phẩm nào được chọn'], 400);
    }
    $totalAmount = 0;
    foreach ($cartItems as $item) {
        $totalAmount += $item->product->price * $item->quantity;
    }
    $totalAmount = intval(round($totalAmount * 1000));

    if ($request->payment_method === 'cash') {
        DB::beginTransaction();
        try {
            $order = Order::create([
                'orderDate'   => now(),
                'status'      => 'pending',
                'description' => "Receiver: {$request->name}, Phone: {$request->phone}, Address: {$request->address}, City: {$request->city}",
                'totalAmount' => $totalAmount,
                'userID'      => $user->id,
            ]);

            foreach ($cartItems as $item) {
                OrderDetail::create([
                    'orderID'   => $order->id,
                    'productID' => $item->productID,
                    'quantity'  => $item->quantity,
                    'price'     => $item->product->price,
                ]);
            }

            CartItem::where('cartID', $cart->id)
                ->whereIn('productID', $selectedItems) // chỉ xóa sản phẩm đã chọn
                ->delete();
            DB::commit();

            return response()->json([
                'message' => 'Đặt hàng thành công (COD)',
                'order_id' => $order->id,
                'total' => $totalAmount,
                'payment_method' => 'cash'
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Có lỗi khi tạo đơn hàng', 'details' => $e->getMessage()], 500);
        }
    }

    // Nếu là MoMo
    return $this->momo_payment($request, $totalAmount);

    // Nếu là VNPay
}


public function execPostRequest($url, $data)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data))
    );
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    //execute post
    $result = curl_exec($ch);
    //close connection
    curl_close($ch);
    return $result;
}

public function momo_payment(Request $request, $totalAmount)
    {
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";

        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';

        $orderInfo = "Thanh toán qua MoMo";
        $amount = (string) $totalAmount;
        $orderId = time() ."";
        $requestType = "payWithATM";
        $requestId = time() . "";
        $redirectUrl = "http://127.0.0.1:8000/cart";
        $ipnUrl      = "https://539a31fc86a5.ngrok-free.app/payment/momo/ipn";
        $extraData = base64_encode(json_encode([
            'user_id' => $request->user()->id,
            'selected_items' => $request->input('selected_items', [])
        ]));

        $rawHash = "accessKey=" . $accessKey .
            "&amount=" . $amount .
            "&extraData=" . $extraData .
            "&ipnUrl=" . $ipnUrl .
            "&orderId=" . $orderId .
            "&orderInfo=" . $orderInfo .
            "&partnerCode=" . $partnerCode .
            "&redirectUrl=" . $redirectUrl .
            "&requestId=" . $requestId .
            "&requestType=" . $requestType;

        $signature = hash_hmac("sha256", $rawHash, $secretKey);

        $data = array(
            'partnerCode' => $partnerCode,
            'partnerName' => "Test",
            "storeId" => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature);

        $result = $this->execPostRequest($endpoint, json_encode($data));
        $jsonResult = json_decode($result, true);

         \Log::info("MoMo response: " . $result);
        return response()->json([
            'payment_method' => 'momo',
            'payUrl' => $jsonResult['payUrl'] ?? null,
            'momo_response'  => $jsonResult
        ]);

    }

    public function momoIpn(Request $request)
    {
        \Log::info('MoMo IPN received:', $request->all());

        if ($request->resultCode == 0) {
            $extraData = json_decode(base64_decode($request->extraData), true);
            \Log::info('ExtraData parsed:', $extraData);

            $userId = $extraData['user_id'] ?? null;
            $selectedItems = $extraData['selected_items'] ?? [];

            $cart = Cart::with('items.product')->where('userID', $userId)->first();
            \Log::info('Cart items count: ' . ($cart ? $cart->items->count() : 0));


            DB::beginTransaction();
            try {
                $cartItems = $cart->items;
                if (!empty($selectedItems)) {
                    $cartItems = $cartItems->filter(function ($item) use ($selectedItems) {
                        return in_array((string)$item->productID, $selectedItems);
                    });
                }

                if ($cartItems->isEmpty()) {
                    return response()->json(['error' => 'Không có sản phẩm nào được chọn']);
                }
                $totalAmount = 0;
                foreach ($cartItems as $item) {
                    $totalAmount += $item->product->price * $item->quantity;
                }

                $totalAmount = intval(round($totalAmount * 1000));

                $order = Order::create([
                    'orderDate'   => now(),
                    'status'      => 'paid',
                    'description' => "Receiver: ...",
                    'totalAmount' => $totalAmount,
                    'userID'      => $userId,
                ]);

                foreach ($cartItems as $item) {
                    OrderDetail::create([
                        'orderID'   => $order->id,
                        'productID' => $item->productID,
                        'quantity'  => $item->quantity,
                        'price'     => $item->product->price,
                    ]);
                }

                CartItem::where('cartID', $cart->id)->delete();

                DB::commit();
                return response()->json(['message' => 'Order success']);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['error' => 'Order fail', 'details' => $e->getMessage()]);
            }
        } else {
            return response()->json(['error' => 'Payment failed']);
        }
    }

}
