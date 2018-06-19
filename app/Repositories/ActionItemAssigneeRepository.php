<?php

namespace App\Repositories;

use App\Models\ActionItemAssignee;
use App\Repositories\Contracts\ActionItemAssigneeRepositoryInterface;

class ActionItemAssigneeRepository extends BaseRepository implements ActionItemAssigneeRepositoryInterface
{

    public function model()
    {
        return new ActionItemAssignee();
    }

    public function removeMemebr($member,$item)
    {
        return $this->model()->where('user_id',$member)->where('action_item_id',$item)->forceDelete();
    }
}