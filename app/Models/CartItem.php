<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'cart_items';
    public $timestamps = false;

    // Cho phép fill các cột khi dùng create()
    protected $fillable = [
        'cartID',
        'productID',
        'quantity'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'productID', 'id');
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cartID', 'id');
    }
}
