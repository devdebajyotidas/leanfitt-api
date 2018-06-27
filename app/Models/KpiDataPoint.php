<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KpiDataPoint extends Model
{
    protected $fillable=[
        'kpi_chart_id',
        'value',
        'target_date',
        'created_by'
    ];

    public function kpiChart(){
        return $this->belongsTo(KpiChart::class);
    }
}
