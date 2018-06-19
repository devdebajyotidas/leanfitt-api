<?php

namespace App\Repositories;

use App\Models\ActionItem;
use App\Models\ActionItemAssignee;
use App\Models\Project;
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

    private function project(){
        return new Project();
    }

    private function assignee(){
        return new ActionItemAssignee();
    }

    public function getAllActionItems(): Collection
    {
        $result=$this->model()->with(['board','assignor','tool','member'])->withCount('comment')->get();
        return $this->formatActionItem($result,'non_board');
    }


    public function getActionItemByTool($tool): Collection
    {
        $result=$this->model()->with(['board','assignor','tool','member'])->withCount('comment')->where('lean_tool_id',$tool)->get();
        return $this->formatData($result,'non_board');
    }

    public function getActionItemMembers($item): Collection
    {
        $result=$this->model()->find($item)->member;
        $data= $result->map(function($item){
            return ['user_id'=>$item['user']['id'],'name'=>$item['user']['full_name'],'avatar'=>$item['user']['avatar']];
        });
        return $data;
    }

    public function getActionItemByProjects($project): Collection
    {
        $ids=$this->project()->find($project)->actionItem()->pluck('id')->toArray();
        $result=$this->model()->with(['board','assignor','tool','member'])->withCount('comment')->whereIn('id',$ids)->get();
        return $this->formatActionItem($result,'non_board');
    }

    public function getActionItemByMember($user): Collection
    {
        $ids=$this->assignee()->where('user_id',$user)->pluck('action_item_id')->toArray();
        $result=$this->model()->with(['board','assignor','tool','member'])->withCount('comment')->whereIn('id',$ids)->get();
        return $this->formatActionItem($result,'non_board');
    }

    public function getActionItemByBoard($board): Collection
    {
        $result=$this->model()->with(['board','assignor','tool','member'])->withCount('comment')->where('board_id',$board)->get();
        return $this->formatData($result,'board');
    }

    public function getActionItemByDepartment($department): Collection
    {
        /*Dont think it is required currently, as the project dont have departments*/
    }

    public function getActionItemDetails($item): Collection
    {
        $result=$this->model()->with(['board','assignor','member','comment'])->find($item);
        return new Collection($result);
    }

    /*Additional functions*/

    protected function formatActionItem($result,$type){
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
                'assignees'=>$item['member']->map(function($member){
                    return['full_name'=>$member['full_name'],'avatar'=>$member['avatar']];
                }),
            ];

            if($type=='non_board') {
                $arr_merged = array_merge($arr, ['board_name' => $item['board']['name'], 'board_id' => $item['board']['id']]);
                return $arr_merged;
            }
            return $arr;
        });
        return $data;
    }

    /*Add -> call base function*/

    /*update-> call base function*/

    public function moveActionItemPosition($item,$position)
    {
        return $this->model()->find($item)->update(['position'=>$position]);
    }

    /*Archive-> call base function*/

    /*Restore-> call base function*/

    /*Force delete-> call base function*/

}