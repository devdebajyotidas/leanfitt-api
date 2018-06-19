<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    protected $fillable = [
        'email',
        'token',
        'user_id',
        'code',
        'request_id',
        'created_at'
    ];
}
