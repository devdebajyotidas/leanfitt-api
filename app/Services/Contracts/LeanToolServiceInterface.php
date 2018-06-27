<?php

namespace App\Services\Contracts;


interface LeanToolServiceInterface
{
    public function index();

    public function create($request);

    public function update($request,$tool_id);

    public function show($tool_id);

    public function delete($tool_id,$user_id);
}