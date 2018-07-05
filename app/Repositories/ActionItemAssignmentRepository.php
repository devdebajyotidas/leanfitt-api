<?php

namespace App\Repositories;


use App\Models\ActionItemAssignment;
use App\Repositories\Contracts\ActionItemAssignmentRepositoryInterface;

class ActionItemAssignmentRepository extends BaseRepository implements ActionItemAssignmentRepositoryInterface
{
    public function model()
    {
        return new ActionItemAssignment();
    }

    public function getAssignments()
    {
        $query=$this->model()
            ->join('action_items as ai','ai.id','=','action_item_assignments.action_item_id')
            ->select(['action_item_assignments.*','ai.name','ai.is_archived'])->get();
        return $query;
    }
}