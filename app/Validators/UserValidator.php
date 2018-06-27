<?php

namespace App\Validators;

class UserValidator extends BaseValidator
{

    public static $rules = [
        "create" => [
            'email' => 'email|required',
            'password' => 'required|confirmed|min:6',
        ],
        "update" => [
            'password' => 'confirmed|min:6',
        ],

    ];

}