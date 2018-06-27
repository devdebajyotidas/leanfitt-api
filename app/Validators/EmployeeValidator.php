<?php

namespace App\Validators;


class EmployeeValidator extends BaseValidator
{
    public static $rules=[
        'create'=>
            [
                'user_id'=>'required',
                'department_id'=>'required',
            ]
    ];
}