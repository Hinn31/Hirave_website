<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetail;

class OrderSeeder extends Seeder
{
    public function run()
    {
        // Tạo user test (nếu chưa có)
        $user = User::first() ?? User::create([
            'fullname'      => 'Test User',
            'username'      => 'testuser',
            'email'         => 'test@example.com',
            'password'      => bcrypt('123456'),
            'date_of_birth' => '1990-01-01',
            'phone'         => '0123456789',
            'role'          => 'customer'
        ]);

        // Tạo 5 sản phẩm mẫu (nếu Product factory đã có)
        $products = Product::factory()->count(5)->create();

        // Trạng thái test
        $statuses = ['pending', 'shipped', 'delivered', 'cancelled'];

        foreach ($statuses as $status) {
            $order = Order::create([
                'orderDate'   => now(),
                'status'      => $status,
                'description' => "Order with status {$status}",
                'totalAmount' => 0,
                'userID'      => $user->id
            ]);

            // Gắn 2 sản phẩm vào mỗi order
            $total = 0;
            foreach ($products->random(2) as $product) {
                $price = rand(10, 100);
                $qty   = rand(1, 3);

                OrderDetail::create([
                    'quantity'  => $qty,
                    'price'     => $price,
                    'orderID'   => $order->id,
                    'productID' => $product->id
                ]);

                $total += $price * $qty;
            }

            // Cập nhật tổng tiền đơn hàng
            $order->update(['totalAmount' => $total]);
        }
    }
}
