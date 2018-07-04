<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportDefaultAssignment extends Model
{
    protected $fillable=[
        'report_id',
        'report_default_id',
        'level'
    ];

    public function report(){
        return $this->belongsTo(Report::class);
    }

    public function default(){
        $this->hasOne(ReportDefault::class);
    }
}
