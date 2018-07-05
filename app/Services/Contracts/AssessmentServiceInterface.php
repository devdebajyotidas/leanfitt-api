<?php

namespace App\Services\Contracts;


interface AssessmentServiceInterface
{
      public function index($user_id);

      public function list($request);

      public function show($tool_id,$user_id);

      public function create($request);
}