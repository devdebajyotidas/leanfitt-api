<?php

namespace App\Validators;


class KpiDataValidator extends BaseValidator
{
    public static $rules=[
      'create'=>[
          'kpi_chart_id'=>'required',
          'value'=>'required',
          'target_date'=>'required',
          'created_by'=>'required'
      ]
    ];
}