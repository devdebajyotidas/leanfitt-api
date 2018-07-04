<?php

namespace App\Validators;


class ReportDefaultValidator extends BaseValidator
{
    public static $rules=[
        'create'=>[
            'report_category_id'=>'required',
            'label'=>'required',
            'level'=>'required'
        ]
    ];
}