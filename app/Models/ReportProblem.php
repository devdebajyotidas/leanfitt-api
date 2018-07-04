<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportProblem extends Model
{
    protected $fillable=[
        'report_id',
        'name'
    ];

    public function report(){
        return $this->belongsTo(Report::class);
    }

    public function reason(){
        return $this->hasMany(ReportReason::class);
    }
}
