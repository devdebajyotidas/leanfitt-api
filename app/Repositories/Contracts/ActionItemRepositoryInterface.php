<?php

namespace App\Repositories\Contracts;

use App\Models\ActionItem;
use App\Models\Department;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Collection;

interface ActionItemRepositoryInterface
{

    /**
     * @param int | ActionItem $item
     * @return Collection
     */
     public function getActionItemMember($item):Collection;

    /**
     * @param int | ActionItem $item
     * @return Collection
     */
     public function getActionItemDepartment($item):Collection;

    /**
     * @param int | ActionItem $item
     * @return Collection
     */
     public function getActionItemProjects($item):Collection;

    /**
     * @param int | ActionItem $item
     * @param int | Project $project
     * @return Collection
     */
     public function actionItemByProjects($item,$project):Collection;

    /**
     * @param int | User $user
     * @return Collection
     */
     public function actionItemByMember($user):Collection;

    /**
     * @param int | ActionItem $item
     * @param int | Department $department
     * @return Collection
     */
     public function actionItemByDepartment($item,$department):Collection;

}