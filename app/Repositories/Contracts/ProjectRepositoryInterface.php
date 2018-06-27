<?php

namespace App\Repositories\Contracts;


interface ProjectRepositoryInterface
{
    public function allProject();

    public function getProject($project_id);
}