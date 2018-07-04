<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportChart extends Model
{
   protected $fillable=[
       'report_id',
       'label',
       'value'
   ];

   public function report(){
       return $this->belongsTo(Report::class);
   }

}
