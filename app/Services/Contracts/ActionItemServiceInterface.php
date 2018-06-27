<?php

namespace App\Services\Contracts;


interface ActionItemServiceInterface
{
   public function index($request,$type);

   public function show($item_id);

   public function create($request);

   public function update($request,$item_id);

   public function addAssignee($request);

   public function removeAssignee($item_id,$assignee_id);

   public function archive($item_id);

   public function restore($item_id);

   public function delete($item_id,$user_id);
}