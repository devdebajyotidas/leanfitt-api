<?php

namespace App\Repositories\Contracts;


use Illuminate\Support\Collection;

interface ProjectRepositoryInterface
{

    public function getOpenProjects():Collection;

    public function getOpenProjectsByOrg($organization):Collection;

    public function getArchivedProjects():Collection;

    public function getArchivedProjectsByOrg($organization):Collection;

    public function getCompletdProjects():Collection;

    public function getCompletdProjectsByOrg($organization):Collection;

    public function getProjectDetails($project):Collection;

    public function getProjectLogs($project):Collection;

    public function complete($project);

}