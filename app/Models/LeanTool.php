<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeanTool extends Model
{
    protected  $fillable=[
        'name',
        'overview',
        'steps',
        'case_studies',
        'quiz',
        'created_by'
    ];

    public function item(){
        $this->hasMany(ActionItem::class);
    }

    public function quizResult(){
        return $this->hasMany(QuizResult::class);
    }

    public function itemAssignment(){
        return $this->belongsTo(ActionItemAssignment::class);
    }
}
