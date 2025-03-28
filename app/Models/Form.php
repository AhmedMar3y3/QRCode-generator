<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'num_of_seats',
        'message',
        'qrcode'
    ];
}
