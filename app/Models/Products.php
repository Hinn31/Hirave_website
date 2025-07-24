<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
     protected $table = 'products';

    protected $fillable = [
        'productName', 'price', 'description', 'imageURL', 'stock', 'categoryID'
    ];

    public function categories()
    {
        return $this->belongsTo(Categories::class, 'categoryID');
    }

    public function reviews()
    {
        return $this->hasMany(Reviews::class, 'productID')->latest('reviewDate');
    }
}
