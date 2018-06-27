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

}