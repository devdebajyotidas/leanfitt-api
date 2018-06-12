<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizResult extends Model
{
    protected $fillable=[
        'lean_tool_id',
        'user_id',
        'score',
        'correct',
        'incorrect',
        'is_completed'
    ];

    public function tool(){
        return $this->belongsTo(LeanTool::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
