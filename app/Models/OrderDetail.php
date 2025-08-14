<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    public $timestamps = false; // bảng này không có created_at, updated_at
    protected $fillable = [
        'quantity', 'price', 'orderID', 'productID'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'orderID', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'productID', 'id');
    }
}
