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
}