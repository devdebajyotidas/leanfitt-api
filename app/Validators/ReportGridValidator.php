<?php

namespace App\Validators;


class ReportGridValidator extends BaseValidator
{
    public static $rules=[
        'create'=>[
            'report_id'=>'required',
            'position'=>'required',
            'value'=>'required'
        ]
    ];
}