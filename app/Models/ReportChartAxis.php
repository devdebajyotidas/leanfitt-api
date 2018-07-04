<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportChartAxis extends Model
{
    protected $fillable=[
        'report_id',
        'x_axis',
        'y_axis'
    ];

    public function report(){
        return $this->belongsTo(Report::class);
    }

    public function chart(){
        return $this->hasManyThrough(ReportChart::class,Report::class,'id','report_id');
    }
}
