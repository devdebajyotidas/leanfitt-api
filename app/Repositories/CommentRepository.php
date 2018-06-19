<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Models\Project;
use App\Repositories\Contracts\CommentRepositoryInterface;
use Illuminate\Support\Collection;

class CommentRepository extends BaseRepository implements CommentRepositoryInterface
{

    public  function model()
    {
        return new Comment();
    }

    public function project(){

        return new Project();
    }

    public function getCommentByUser($id): Collection
    {
        $result=$this->model()->with('user')->where('user_id',$id)->get();
        return$result;
    }

    public function getCommentByActionItem($id): Collection
    {
        $result=$this->model()->with('user')->where('action_item_id',$id)->get();
        return $result;
    }

    //incomplete, complete the project model first
    public function getCommentsByProject($id): Collection
    {
       $ids=$this->project()->find($id)->user()->pluck('id')->toArray();
       $result=$this->model()->whereIn('user_id',$ids)->get();
       return $result;
    }

   /*Add comment*/

    /*update comment*/

    /*Remove comment*/
}