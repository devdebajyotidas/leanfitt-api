<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActionItemAssignment extends Model
{
    protected $fillable=[
        'action_item_id',
        'target_date',
        'note'
    ];

    public function item(){
        return $this->belongsTo(ActionItem::class,'action_item_id','id');
    }
}
