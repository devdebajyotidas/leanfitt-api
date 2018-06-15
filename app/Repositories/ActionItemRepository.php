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
       $result=$this->model()->with(['tool','board','assignor'])->get();
//       $data=$result->map(function($item){
//
//       });
        return $result;
    }


    public function getActionItemByTool($tool): Collection
    {
        // TODO: Implement getActionItemByTool() method.
    }

    public function getActionItemMembers($item): Collection
    {
        // TODO: Implement getAllMemberFromAI() method.
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

    public function getActionItemByDepartment($department): Collection
    {
        // TODO: Implement getActionItemByDepartment() method.
    }

    public function getActionItemDetails($item): Collection
    {
        // TODO: Implement getActionItemDetails() method.
    }
}