<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $hidden=[
        'attachable_id',
        'attachable_type',
        'created_by'
    ];

    protected $fillable=[
        'url',
        'created_by'
    ];

    public function attachable(){
        $this->morphTo();
    }
}
