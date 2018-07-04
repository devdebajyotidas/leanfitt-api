<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportGrid extends Model
{
    protected $fillable=[
        'report_id',
        'position',
        'value'
    ];

    public function report(){
        return $this->belongsTo(Report::class);
    }
}
