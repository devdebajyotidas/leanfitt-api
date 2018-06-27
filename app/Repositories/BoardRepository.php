<?php

namespace App\Repositories;

use App\Models\Board;
use App\Repositories\Contracts\BoardRepositoryInterface;

class BoardRepository extends BaseRepository implements BoardRepositoryInterface
{

    public function model()
    {
        return new Board();
    }

}