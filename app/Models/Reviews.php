<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
    public $timestamps = false;
    protected $table = "Reviews";
    protected $fillable =
    [ 'rating', 'comment', 'reviewDate', 'userID', 'productID'];

     public function products()
    {
        return $this->belongsTo(Products::class, 'productID');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'userID');
    }

}
