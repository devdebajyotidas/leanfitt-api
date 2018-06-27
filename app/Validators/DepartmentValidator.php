<?php

namespace App\Validators;


class DepartmentValidator extends BaseValidator
{
    public  static $rules=[
        'create'=>[
            'name'=>'required',
            'organization_id'=>'required',
            'created_by'=>'required'
        ],
        'update'=>[
            'name'=>'required'
        ]
    ];
}