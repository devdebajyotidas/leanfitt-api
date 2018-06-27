<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizResult extends Model
{
    protected $fillable=[
        'lean_tool_id',
        'employee_id',
        'score',
        'correct',
        'incorrect',
        'is_completed'
    ];

    public function tool(){
        return $this->belongsTo(LeanTool::class);
    }

    public function employee(){
        return $this->belongsTo(Employee::class);
    }
}
