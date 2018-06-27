<?php

namespace App\Services\Contracts;


interface QuizServiceInterface
{
   public function index($user_id);

   public function show($tool_id,$user_id);

   public function taken($request);

   public function create($request);

}