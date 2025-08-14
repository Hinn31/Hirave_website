<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
 public function index()
{
    $orders = Order::with(['orderDetails.product'])->get();

    // Đếm số lượng theo trạng thái
    $orderCounts = [
        'All'       => $orders->count(),
        'Waiting'   => $orders->where('status', 'pending')->count(),
        'Progress'  => $orders->where('status', 'shipped')->count(),
        'Transport' => $orders->where('status', 'delivered')->count(),
        'Complete'  => $orders->where('status', 'complete')->count(),
        'Canceled'  => $orders->where('status', 'cancelled')->count(),
    ];

    // Nhóm đơn hàng theo status
    $ordersByStatus = $orders->groupBy(function ($order) {
        switch ($order->status) {
            case 'pending':   return 'Waiting';
            case 'shipped':   return 'Progress';
            case 'delivered': return 'Transport';
            case 'complete':  return 'Complete';
            case 'cancelled': return 'Canceled';
            default:          return 'Other';
        }
    });

    return response()->json([
        'orderCounts' => $orderCounts,
        'orders' => $ordersByStatus
    ]);
}

    public function store(Request $request)
    {
        $order = Order::create($request->all());
        return response()->json($order, 201);
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update($request->all());
        return response()->json($order);
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return response()->json(['message' => 'Order deleted']);
    }
}
