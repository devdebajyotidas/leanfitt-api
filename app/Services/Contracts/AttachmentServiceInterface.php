<?php

namespace App\Services\Contracts;

use App\Models\ActionItem;
use App\Models\Attachment;

interface AttachmentServiceInterface
{
    /**
     * @param $data
     * @return bool
     */
    public function addAttachment($data):bool;

    /**
     * @param int|Attachment $attachment
     * @param int|ActionItem $item
     * @return bool
     */
    public function removeAttachment($attachment,$item):bool;

    /**
     * @param $data
     * @return bool
     */
    public function updateAttachment($data):bool;
}