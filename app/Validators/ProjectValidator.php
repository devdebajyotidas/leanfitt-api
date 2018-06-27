<?php

namespace App\Validators;


class ProjectValidator extends BaseValidator
{
    public static $rules=[
        'create'=>[
            'organization_id'=>'required',
            'name'=>'required',
            'goal'=>'required',
            'leader'=>'required',
            'lean_sensie'=>'required',
            'start_date'=>'required',
            'end_date'=>'required',
            'created_by'=>'required'
        ]
    ];
}