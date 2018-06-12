<?php

namespace App\Services\Contracts;

interface CommentServiceInterface
{
    /**
     * @param $data
     * @return bool
     */
    public function addComment($data):bool;

    /**
     * @param $data
     * @return bool
     */
    public function updateComment($data):bool;

    /*Not sure if needed*/
    public function removeComment($comment):bool;
}