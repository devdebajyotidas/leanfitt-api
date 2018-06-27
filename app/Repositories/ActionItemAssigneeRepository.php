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

}