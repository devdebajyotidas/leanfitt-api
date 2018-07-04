<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable=[
        'action_item_id',
        'comment',
        'user_id'
    ];

    public function item(){
        return $this->belongsTo(ActionItem::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}
