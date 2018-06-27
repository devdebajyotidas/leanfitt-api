<?php

namespace App\Services\Contracts;


interface ProjectServiceInterface
{
    public function index($request);

    public function show($project_id);

    public function create($request);

    public function update($request,$project_id);

    public function archive($project_id,$user_id);

    public function restore($project_id,$user_id);

    public function complete($project_id,$user_id);

    public function delete($project_id,$user_id);
}