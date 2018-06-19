<?php

namespace App\Repositories\Contracts;

use App\Models\Attachment;
use App\Models\Project;
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

    public function project(){
        return new Project();
    }

    public function getAttachmentByActionItem($item): Collection
    {
        $query=$this->model()->where('action_item_id',$item)->get();
        return $query;
    }

    public function getAttachmentByUser($user): Collection
    {
        $query=$this->model()->where('user_id',$user)->get();
        return $query;
    }

    public function getAttachmentByProject($project): Collection
    {
        /*Revisit*/
    }


    public function addAttachment($data)
    {

    }

    public function updateAttachment($data)
    {
        // TODO: Implement updateAttachment() method.
    }

    public function removeAttachment($attachment, $item)
    {
        // TODO: Implement removeAttachment() method.
    }
}