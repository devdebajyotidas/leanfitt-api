<?php

namespace App\Validators;


class ReportElementValidator extends BaseValidator
{
    public static $rules=[
        'create'=>[
            'report_default_id'=>'required',
            'label'=>'required',
        ]
    ];
}