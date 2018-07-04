<?php

namespace App\Validators;


class ReportAssignmentValidator extends BaseValidator
{
   public static $rules=[
       'create'=>[
           'report_id'=>'required',
           'report_default_id'=>'required'
       ]
   ];
}