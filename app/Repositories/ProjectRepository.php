<?php

namespace App\Repositories;

use App\Models\ActionItem;
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
        $result=$this->model()->where('is_archived',1)->with('organization')->get();
        return $this->listView($result);
    }

    public function getArchivedProjectsByOrg($organization): Collection
    {
        $result=$this->model()->where('is_archived',1)->where('organization_id',$organization)->get();
        return $result;
    }

    public function getOpenProjects(): Collection
    {
        $result=$this->model()->with('organization')->where('is_archived',0)->where('is_completed',0)->get();
        return new Collection($result);
    }

    public function getOpenProjectsByOrg($organization): Collection
    {
        $result=$this->model()->where('is_archived',0)->where('is_completed',0)->where('organization_id',$organization)->get();
        return $result;
    }

    public function getCompletdProjects(): Collection
    {
        $result=$this->model()->with('organization')->where('is_archived',0)->where('is_completed',1)->get();
        return $result;
    }

    public function getCompletdProjectsByOrg($organization): Collection
    {
        $result=$this->model()->where('is_archived',0)->where('is_completed',1)->where('organization_id',$organization)->get();
        return $result;
    }

    public function getProjectDetails($project): Collection
    {
          $result=$this->model()->with(['leader','sensie'])->find($project);
          return new Collection($result);
    }

    public function getProjectLogs($project): Collection
    {
        /*Not set yet*/
    }


}