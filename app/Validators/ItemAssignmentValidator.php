<?php

namespace App\Validators;


class ItemAssignmentValidator extends BaseValidator
{
    public static $rules=[
        'create'=>[
            'action_item_id',
            'target_date'
        ]
    ];
}