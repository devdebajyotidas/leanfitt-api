<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordResetLog extends Model
{
    protected $fillable = [
        'account_id',
        'code',
        'request_id'
    ];
}
