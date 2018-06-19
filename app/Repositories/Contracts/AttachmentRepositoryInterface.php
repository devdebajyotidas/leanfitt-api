<?php

namespace App\Repositories\Contracts;

use App\Models\ActionItem;
use App\Models\Attachment;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Collection;

interface AttachmentRepositoryInterface
{
    /**
     * @param int|ActionItem $item
     * @return Collection
     */
    public function getAttachmentByActionItem($item):Collection;

    /**
     * @param int|User $user
     * @return Collection
     */
    public function getAttachmentByUser($user):Collection;

    /**
     * @param int|Project $project
     * @return Collection
     */
    public function getAttachmentByProject($project):Collection;

    public function addAttachment($data);

    public function removeAttachment($attachment,$item);

    public function updateAttachment($data);
}