<?php

namespace App\Repositories\Contracts;


use Illuminate\Support\Collection;

interface ProjectRepositoryInterface
{

    public function getAllProjects():Collection;
    public function getOpenProjects():Collection;
    public function getArchivedProjects():Collection;
    public function getProjectDetails($project):Collection;
    public function getProjectLogs($project):Collection;

}