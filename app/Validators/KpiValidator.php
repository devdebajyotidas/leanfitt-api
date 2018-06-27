<?php

namespace App\Validators;


class KpiValidator extends BaseValidator
{

    public  static $rules=[
        'create'=>[
            'project_id'=>'required',
            'title'=>'required',
            'x_label'=>'required',
            'y_label'=>'required',
            'start_date'=>'required',
            'end_date'=>'required',
            'created_by'=>'required'
        ]
    ];
}