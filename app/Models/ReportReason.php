<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportReason extends Model
{
    protected $fillable=[
        'report_problem_id',
        'why'
    ];

    public function problem(){
        return $this->belongsTo(ReportProblem::class);
    }
}
