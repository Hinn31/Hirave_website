<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CartItem;
 

class Cart extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'carts';
    public $timestamps = false;

    protected $fillable = ['userID', 'status'];

    public function items()
    {
        return $this->hasMany(CartItem::class, 'cartID', 'id'); 
    }
}
