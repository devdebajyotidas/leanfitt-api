<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectActivity extends Model
{
    protected $fillable=[
        'added_by',
        'project_id',
        'log'
    ];

    public function project(){
        return $this->belongsTo(Project::class);
    }
}
