<?php

namespace App\Services;

use App\Repositories\CommentRepository;
use App\Services\Contracts\CommentServiceInterface;

class CommentService implements CommentServiceInterface
{

    protected $commentRepository;
    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository=$commentRepository;
    }

    public function addComment($data): bool
    {
        // TODO: Implement addComment() method.
    }

    public function updateComment($data): bool
    {
        // TODO: Implement updateComment() method.
    }

    public function removeComment($comment): bool
    {
        // TODO: Implement removeComment() method.
    }
}