<?php

namespace App\Repositories\Contracts;

use App\Models\ActionItem;
use App\Models\User;
use Illuminate\Support\Collection;

interface CommentRepositoryInterface
{
    /**
     * @param int|User $user
     * @return Collection
     */
    public function getCommentByUser($user):Collection;

    /**
     * @param int|ActionItem $item
     * @return Collection
     */
    public function getCommentByActionItem($item):Collection;

    /**
     * @param int|Project $project
     * @return Collection
     */
    public function getCommentsByProject($project):Collection;

}