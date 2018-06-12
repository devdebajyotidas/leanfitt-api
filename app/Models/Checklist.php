<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
   protected $fillable=[
       'action_item_id',
       'label',
       'is_checked'
   ];

   public function item(){
       return $this->belongsTo(ActionItem::class);
   }

}
