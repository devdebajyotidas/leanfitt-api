<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KpiDataPoint extends Model
{
    protected $fillable=[
        'kpi_id',
        'value',
        'target_date'
    ];

    public function kpiChart(){
        return $this->belongsTo(KpiChart::class);
    }
}
