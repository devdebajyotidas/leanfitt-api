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
     public function getActionItemMembers($item):Collection;

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
     public function getActionItemByMember($user):Collection;

    /**
     * @param $department
     * @return Collection
     */
     public function getActionItemByDepartment($department):Collection;

    /**
     * @param $board
     * @return Collection
     */
     public function getActionItemByBoard($board):Collection;

}