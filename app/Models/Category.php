<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories'; // không bắt buộc nếu tên đúng chuẩn
    protected $fillable = ['categoryName'];
}
