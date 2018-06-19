<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    protected $fillable=[
        'action_item_id',
        'label',
        'color'
    ];

    public function item(){
        return $this->belongsTo(ActionItem::class);
    }

}
