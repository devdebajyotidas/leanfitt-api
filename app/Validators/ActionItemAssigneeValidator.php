<?php

namespace App\Validators;


class ActionItemAssigneeValidator extends BaseValidator
{
    public static $rules=[
        'create'=>[
            'user_id'=>'required',
            'action_item_id'=>'required'
        ]
    ];
}