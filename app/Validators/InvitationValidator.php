<?php

namespace App\Validators;


class InvitationValidator extends BaseValidator
{
    public static $rules = [
        "create" => [
            'email' => 'email|required',
            'phone' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'department_id'=>'required',
            'organization_id'=>'required'
        ]
    ];
}