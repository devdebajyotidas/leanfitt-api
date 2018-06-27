<?php

namespace App\Validators;


class LeanToolValidator extends BaseValidator
{
    public static $rules=[
        'create'=>[
            'name'=>'required',
            'created_by'=>'required',
        ]
    ];
}