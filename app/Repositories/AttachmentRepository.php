<?php

namespace App\Repositories\Contracts;

use App\Models\Attachment;
use App\Repositories\BaseRepository;
use Illuminate\Support\Collection;

class AttachmentRepository extends BaseRepository implements AttachmentRepositoryInterface
{

    /**
     * @inheritdoc
     */
    public function model()
    {
        return new Attachment();
    }

    public function getAllAttachment(): Collection
    {
        // TODO: Implement getAllAttachment() method.
    }

    public function getAttachmentByActionItem($item): Collection
    {
        // TODO: Implement getAttachmentByActionItem() method.
    }

    public function getAttachmentByUser($user): Collection
    {
        // TODO: Implement getAttachmentByUser() method.
    }

    public function getAttachmentByProject($project): Collection
    {
        // TODO: Implement getAttachmentByProject() method.
    }

    public function attachmentExists($attachment): bool
    {
        // TODO: Implement attachmentExists() method.
    }
}