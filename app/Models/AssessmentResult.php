<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentResult extends Model
{
    protected $fillable=[
        'lean_tool_id',
        'employee_id',
        'result'
    ];

    public function employee(){
        return $this->belongsTo(Employee::class,'employee_id','id');
    }

    public function tool(){
        return $this->belongsTo(LeanTool::class);
    }
}
