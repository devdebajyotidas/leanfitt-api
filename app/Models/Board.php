<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
   protected $fillable=[
       'name',
   ];

   public function item(){
       return $this->hasMany(ActionItem::class);
   }
}
