<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected  $table=[
        'action_item_id',
        'url',
        'user_id'
    ];

    public function item(){
        return $this->belongsTo(ActionItem::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
