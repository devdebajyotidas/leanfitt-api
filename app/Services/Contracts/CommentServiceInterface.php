<?php

namespace App\Services\Contracts;


interface CommentServiceInterface
{
    public function create($request);

    public function update($request,$comment_id);

    public function delete($comment_id,$user_id);
}