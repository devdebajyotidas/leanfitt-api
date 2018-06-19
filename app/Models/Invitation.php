<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $fillable=[
        'first_name',
        'last_name',
        'email',
        'phone',
        'token',
        'is_joined'
    ];
}
