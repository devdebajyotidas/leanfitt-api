<?php

namespace App\Repositories;

use App\Models\ActionItem;
use App\Models\ActionItemAssignee;
use App\Models\Project;
use App\Repositories\Contracts\ActionItemRepositoryInterface;
use Illuminate\Support\Collection;

class ActionItemRepository extends BaseRepository implements ActionItemRepositoryInterface
{

    public  function  model()
    {
        return new ActionItem();
    }

    public function allProjectActions(){
        $query=$this->model()->join('projects as pr','pr.id','=','action_items.itemable_id')
            ->where('action_items.itemable_type','App\Models\Project')
            ->leftJoin('action_item_assignees as ais','action_items.id','=','ais.action_item_id')
            ->select(['action_items.*','pr.organization_id','ais.id as user_id'])
            ->withCount('comments')->withCount('member')->withCount('attachments');
        return $query;
    }

    public function allReportActions(){
        $query=$this->model()->join('reports as rep','rep.id','=','action_items.itemable_id')
            ->join('projects as pr','pr.id','=','rep.project_id')
            ->where('action_items.itemable_type','App\Models\Report')
            ->leftJoin('action_item_assignees as ais','action_items.id','=','ais.action_item_id')
            ->select(['action_items.*','pr.organization_id','ais.id as user_id'])
            ->withCount('comments')->withCount('member')->withCount('attachments');
        return $query;
    }

    public function getItem($id)
    {
        $query=$this->model()->with(['assignor','board','member.user','comments.user','attachments'])->where('id',$id)->where('is_archived',0)->first();
        return $query;
    }
}