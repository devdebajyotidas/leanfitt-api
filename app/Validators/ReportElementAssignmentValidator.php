<?php

namespace App\Validators;


class ReportElementAssignmentValidator extends BaseValidator
{
    public static $rules=[
        'create'=>[
            'report_id'=>'required',
            'report_default_id'=>'required',
            'report_default_element_id'=>'required',
        ]
    ];
}