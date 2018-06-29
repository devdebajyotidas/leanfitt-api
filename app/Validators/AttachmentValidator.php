<?php

namespace App\Validators;


class AttachmentValidator extends BaseValidator
{
    public static $rules=[
        'create'=>[
            'created_by'=>'required',
            'type'=>'required',
        ]
    ];
}