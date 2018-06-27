<?php

namespace App\Repositories\Contracts;

use App\Models\Attachment;
use App\Models\Project;
use App\Repositories\BaseRepository;
use Illuminate\Support\Collection;

class AttachmentRepository extends BaseRepository implements AttachmentRepositoryInterface
{

    public function model()
    {
        return new Attachment();
    }
}