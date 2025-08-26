<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller; // ✅ cần import

use App\Models\Order; // Đảm bảo bạn đã tạo model Order
use Illuminate\Http\Request;

class OrderManagementAdminController extends Controller
{
    /**
     * Hiển thị danh sách các đơn hàng.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Lấy dữ liệu tìm kiếm từ form (nếu có)
        $search = $request->input('search');

        $orders = Order::query()
            ->when($search, function ($query) use ($search) {
                $query->where('customer_name', 'like', "%{$search}%")
                      ->orWhere('order_id', 'like', "%{$search}%");
            })
            ->paginate(10); 

return view('pages.order_management_admin', compact('orders'));    }

    /**
     * Hiển thị chi tiết một đơn hàng.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        // Lấy đơn hàng dựa trên ID, ném 404 nếu không tìm thấy
        $order = Order::findOrFail($id);

        // Truyền dữ liệu vào view
        return view('orders.show', compact('order'));
    }

    /**
     * Xóa một đơn hàng.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Đơn hàng đã được xóa thành công');
    }
}