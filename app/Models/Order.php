<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $primaryKey = 'id';
    protected $fillable = [
        'orderDate', 'status', 'description', 'totalAmount', 'userID'
    ];

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'orderID', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'userID', 'id');
    }
}
