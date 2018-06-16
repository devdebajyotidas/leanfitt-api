<?php

namespace App\Repositories;

use App\Models\Project;
use App\Repositories\Contracts\ProjectRepositoryInterface;
use Illuminate\Support\Collection;

class ProjectRepository extends BaseRepository implements ProjectRepositoryInterface
{

    public function model()
    {
        return new Project();
    }

    public function getArchivedProjects(): Collection
    {
        $result=$this->model()->where('is_archived',1)->get();
    }

    public function getArchivedProjectsByOrg($organization): Collection
    {
        $result=$this->model()->where('is_archived',1)->get();
    }

    public function getOpenProjects(): Collection
    {

    }

    public function getOpenProjectsByOrg($organization): Collection
    {

    }

    public function getCompletdProjects(): Collection
    {
        // TODO: Implement getCompletdProjects() method.
    }

    public function getCompletdProjectsByOrg($organization): Collection
    {
        // TODO: Implement getCompletdProjects() method.
    }

    public function getProjectDetails($project): Collection
    {

    }

    public function getProjectLogs($project): Collection
    {

    }
}