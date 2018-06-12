<?php

namespace App\Services;

use App\Repositories\Contracts\AttachmentRepository;
use App\Services\Contracts\AttachmentServiceInterface;

class AttachmentService implements AttachmentServiceInterface
{

    protected $attachmentRepository;
    public function __construct(AttachmentRepository $attachmentRepository)
    {
        $this->attachmentRepository=$attachmentRepository;
    }

    public function addAttachment($data): bool
    {
        // TODO: Implement addAttachment() method.
    }

    public function updateAttachment($data): bool
    {
        // TODO: Implement updateAttachment() method.
    }

    public function removeAttachment($attachment, $item): bool
    {
        // TODO: Implement removeAttachment() method.
    }
}