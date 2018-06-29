<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable=[
        'mime_type',
        'size',
        'file_name'
    ];
}
