<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KpiChart extends Model
{

    protected $fillable=[
        'project_id',
        'title',
        'x_label',
        'y_label',
        'start_date',
        'end_date'
    ];

    public function project(){
        return $this->hasOne(Project::class);
    }

    public function kpiData(){
        return $this->hasMany(KpiDataPoint::class);
    }
}
