<?php

namespace App\Repositories;

use App\Models\LeanTool;
use App\Repositories\Contracts\LeanToolsRepositoryInterface;
use Illuminate\Support\Collection;

class LeantoolRepository extends BaseRepository implements LeanToolsRepositoryInterface
{

    public function model()
    {
        return new LeanTool();
    }

    public function getToolDetailsByName($id, string $name): Collection
    {
        $this->renderJSON($this->model()->find($id)->first($name));
    }

}