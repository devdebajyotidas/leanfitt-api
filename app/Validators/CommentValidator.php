<?php

namespace App\Validators;


class CommentValidator extends BaseValidator
{
      public static $rules=[
         'create'=>[
             'comment'=>'required',
             'user_id'=>'required',
             'type'=>'required',
         ]
      ];
}