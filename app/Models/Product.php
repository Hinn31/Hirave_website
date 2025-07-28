<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'productName',
        'slug',
        'description',
        'price',
        'oldPrice',
        'image',
        'stock',
        'material', 
        'categoryID',
        'is_best_seller',
        'is_new_product',
    ];

    public function category()
{
    return $this->belongsTo(Category::class, 'categoryID');
}
}