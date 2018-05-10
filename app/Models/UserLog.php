<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    protected $fillable = [
        'fcm_token',
        'device_id',
        'account_id'
    ];
}
