<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    // Các cột cho phép ghi dữ liệu
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'message',
    ];
}
