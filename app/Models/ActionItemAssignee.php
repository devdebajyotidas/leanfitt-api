<?php

namespace App\Models;

use App\Traits\UserAttributes;
use Illuminate\Database\Eloquent\Model;

class ActionItemAssignee extends Model
{
    use UserAttributes;
   protected $fillable=[
       'action_item_id',
       'user_id',
   ];

   protected $appends=[
       'full_name',
       'avatar',
   ];

   public function item(){
       return $this->belongsTo(ActionItem::class);
   }

   public function user(){
       return $this->belongsTo(User::class);
   }
}
