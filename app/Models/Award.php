<?php

namespace App\Models;

use App\Traits\UserAttributes;
use Illuminate\Database\Eloquent\Model;

class Award extends Model
{
    use UserAttributes;
    protected  $fillable=[
        'user_id',
        'title',
        'type',
        'description'
    ];

    protected $appends = [
        'first_name',
        'last_name',
        'full_name',
        'email',
        'phone',
        'avatar',
    ];


    public function user(){
        $this->belongsTo(User::class);
    }
}
