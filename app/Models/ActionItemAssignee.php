<?php

namespace App\Models;

use App\Traits\UserAttributes;
use Illuminate\Database\Eloquent\Model;

class ActionItemAssignee extends Model
{
   protected $fillable=[
       'action_item_id',
       'user_id',
   ];


   public function item(){
       return $this->belongsTo(ActionItem::class);
   }

   public function user(){
       return $this->belongsTo(User::class);
   }
}
