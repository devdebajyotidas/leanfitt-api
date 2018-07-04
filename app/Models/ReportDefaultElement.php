<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportDefaultElement extends Model
{
    protected $fillable=[
        'report_default_id',
        'sort',
        'label'
    ];

    public function default(){
        return $this->belongsTo(ReportDefault::class);
    }

    public function assignment(){
        return $this->belongsTo(ReportElementAssignment::class,'id','report_default_element_id');
    }
}
