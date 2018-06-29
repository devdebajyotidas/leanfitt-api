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

    public function allProject()
    {
        $query=$this->model()->with(['actionItem.member','leaderData','sensie'])->withCount('attachments')->withCount('comments');
        return $query;
    }

    public function getProject($project_id)
    {
        $query=$this->model()->with(['actionItem.member.user','leaderData','sensie','activity.user','comments.user','attachments'])->where('id',$project_id)->first();
        return $query;
    }

}