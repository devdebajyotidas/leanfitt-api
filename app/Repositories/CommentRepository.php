<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Repositories\Contracts\CommentRepositoryInterface;
use Illuminate\Support\Collection;

class CommentRepository extends BaseRepository implements CommentRepositoryInterface
{

    public  function model()
    {
        return new Comment();
    }

    public function getCommentByUser($user): Collection
    {
        // TODO: Implement getCommentByUser() method.
    }

    public function getCommentByActionItem($item): Collection
    {
        // TODO: Implement getCommentByActionItem() method.
    }

}