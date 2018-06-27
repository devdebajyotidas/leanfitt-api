<?php

namespace App\Validators;


class QuizValidator extends BaseValidator
{
    public static $rules=[
        'create'=>[
            'lean_tool_id'=>'required',
            'employee_id'=>'required',
            'correct'=>'required',
            'incorrect'=>'required'
        ]
    ];
}