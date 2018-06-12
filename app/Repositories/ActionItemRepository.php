<?php

namespace App\Repositories;

use App\Models\ActionItem;
use App\Repositories\Contracts\ActionItemRepositoryInterface;
use Illuminate\Support\Collection;

class ActionItemRepository extends BaseRepository implements ActionItemRepositoryInterface
{

    /**
     * @inheritdoc
     */
    public  function  model()
    {
        return new ActionItem();
    }

    public function getAllActionItems(): Collection
    {
        // TODO: Implement getAllActionItems() method.
    }

    public function getActionItemDetails($item): Collection
    {
        // TODO: Implement getActionItemDetails() method.
    }

    public function getActionItemByTool($tool): Collection
    {
        // TODO: Implement getActionItemByTool() method.
    }

    public function getAllMemberFromAI($item): Collection
    {
        // TODO: Implement getAllMemberFromAI() method.
    }

    public function getAllDepartmentFromAI($item): Collection
    {
        // TODO: Implement getAllDepartmentFromAI() method.
    }

    public function getActionItemByProjects($item, $project): Collection
    {
        // TODO: Implement getActionItemByProjects() method.
    }

    public function getActionItemByMember($user): Collection
    {
        // TODO: Implement getActionItemByMember() method.
    }

    public function getActionItemByBoard($board): Collection
    {
        // TODO: Implement getActionItemByBoard() method.
    }

    public function getActionItemByDepartment($item, $department): Collection
    {
        // TODO: Implement getActionItemByDepartment() method.
    }

}