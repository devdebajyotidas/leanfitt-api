<?php

namespace App\Validators;


class AssessmentResultValidator extends BaseValidator
{
    public static $rules=[
      'create'=>[
          'lean_tool_id',
          'employee_id',
          'result'
      ]
    ];
}