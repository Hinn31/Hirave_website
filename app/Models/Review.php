<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['rating', 'comment', 'reviewDate','userID', 'productID'];

    public function user()
    {
        return $this->belongsTo(User::class, 'userID');
    }

}
