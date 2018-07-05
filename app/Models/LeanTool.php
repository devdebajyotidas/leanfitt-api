<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeanTool extends Model
{
    protected  $fillable=[
        'name',
        'featured_image',
        'overview',
        'steps',
        'case_studies',
        'quiz',
        'assessment',
        'created_by'
    ];

    public function item(){
        $this->hasMany(ActionItem::class);
    }

    public function quizResult(){
        return $this->hasMany(QuizResult::class);
    }

    public function assessmentResult(){
        return $this->hasMany(AssessmentResult::class,'lean_tool_id','id');
    }
}
