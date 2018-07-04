<?php

namespace App\Validators;


class ReportChartValidator extends BaseValidator
{
    public static $rules=[
        'create'=>[
            'report_id'=>'required',
            'label'=>'required',
            'value'=>'required'
        ]
    ];
}