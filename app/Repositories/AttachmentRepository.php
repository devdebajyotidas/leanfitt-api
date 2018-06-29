<?php

namespace App\Repositories\Contracts;

use App\Models\Attachment;
use App\Repositories\BaseRepository;


class AttachmentRepository extends BaseRepository implements AttachmentRepositoryInterface
{

    public function model()
    {
        return new Attachment();
    }
}