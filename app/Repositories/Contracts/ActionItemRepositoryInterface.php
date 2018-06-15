<?php

namespace App\Repositories\Contracts;

use App\Models\ActionItem;
use App\Models\Board;
use App\Models\Department;
use App\Models\LeanTool;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Collection;

interface ActionItemRepositoryInterface
{

    /**
     * @return Collection
     */
    public function getAllActionItems():Collection;

    /**
     * @param int|ActionItem $item
     * @return Collection
     */
    public function getActionItemDetails($item):Collection;

    /**
     * @param int| LeanTool $tool
     * @return Collection
     */
    public function getActionItemByTool($tool):Collection;

    /**
     * @param int | ActionItem $item
     * @return Collection
     */
     public function getAllMemberFromAI($item):Collection;

    /**
     * @param int | ActionItem $item
     * @return Collection
     */
     public function getAllDepartmentFromAI($item):Collection;

    /**
     * @param int | ActionItem $item
     * @param int | Project $project
     * @return Collection
     */
     public function getActionItemByProjects($item,$project):Collection;

    /**
     * @param int | User $user
     * @return Collection
     */
     public function getActionItemByMember($filter,$sort,$sort_val,$user):Collection;

    /**
     * @param $filter
     * @param $sort
     * @param $sort_val
     * @param $department
     * @return Collection
     */
     public function getActionItemByDepartment($filter,$sort,$sort_val,$department):Collection;

    /**
     * @param array $filter
     * @param string $sort
     * @param mixed $sort_val
     * @param int $board
     * @return Collection
     */
     public function getActionItemByBoard($filter,$sort,$sort_val,$board):Collection;

}