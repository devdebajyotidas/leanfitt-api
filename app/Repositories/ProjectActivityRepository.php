<?php

namespace App\Repositories;


use App\Models\ProjectActivity;
use App\Repositories\Contracts\ProjectActivityRepositoryInterface;

class ProjectActivityRepository extends BaseRepository implements ProjectActivityRepositoryInterface
{

    public function model()
    {
        return new ProjectActivity();
    }
}