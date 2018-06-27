<?php

namespace App\Services\Contracts;


interface AttachmentServiceInterface
{
    public function create($request);

    public function delete($attachment_id,$user_id);
}