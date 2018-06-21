<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    const CREATED_AT = 'last_login';
    const UPDATED_AT = 'last_login';

    protected $fillable = [
        'user_id',
        'uuid',
        'fcm_token',
        'api_token',
        'is_active',
    ];

    protected $dates = [
        'last_login'
    ];

}
