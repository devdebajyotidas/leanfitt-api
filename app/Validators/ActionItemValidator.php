<?php
/**
 * Created by PhpStorm.
 * User: samir
 * Date: 6/19/2018
 * Time: 10:36 AM
 */

namespace App\Validators;


class ActionItemValidator
{
    public static $rules=[
        'create'=>[
            'name'=>'required',
            'lean_tool_id'=>'required',
            'board_id'=>'required',
            'assignor_id'=>'required',
            'position'=>'required',
            'due_date'=>'required',
        ]
    ];
}