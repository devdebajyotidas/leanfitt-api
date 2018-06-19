<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Award extends Model
{
    protected  $fillable=[
        'user_id',
        'title',
        'type',
        'description'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
