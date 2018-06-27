<?php

namespace App\Repositories;


use App\Models\Media;
use App\Repositories\Contracts\MediaRepositoryInterface;

class MediaRepository extends BaseRepository implements MediaRepositoryInterface
{
    public function model()
    {
        return new Media();
    }
}