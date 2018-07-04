<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportElementAssignment extends Model
{
    protected $fillable=[
        'report_id',
        'report_default_id',
        'report_default_element_id',
        'level'
    ];

    public function report(){
        return $this->belongsTo(Report::class);
    }

    public function default(){
        return $this->hasOne(ReportDefault::class);
    }

    public function element(){
        return $this->hasOne(ReportDefaultElement::class);
    }
}
