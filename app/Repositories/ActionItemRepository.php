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
        $result=$this->model()->with(['board','assignor','tool','member'])->withCount('comment')->get();
        return $this->formatData($result,'non_board');
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

    /*External function*/

    function formatData($result,$type){
        return $result;
        $data=$result->map(function($item) use($type){
            $arr= [
                'tool_id'=>$item['lean_tool_id'],
                'title'=>$item['name'],
                'assignor_id'=>$item['assignor']['id'],
                'assignor_name'=>$item['assignor']['first_name'].' '.$item['assignor']['last_name'],
                'assignor_avatar'=>$item['assignor']['avatar'],
                'tool_name'=>$item['tool']['name'],
                'tool_id'=>$item['tool']['id'],
                'comment'=>$item['comment_count'],
                'assignees'=>$item['member']
            ];

            if($type=='non_board') {
                $arr_merged = array_merge($arr, ['board_name' => $item['board']['name'], 'board_id' => $item['board']['id']]);
                return $arr_merged;
            }

            return $arr;
        });

        return $data;

    }
}