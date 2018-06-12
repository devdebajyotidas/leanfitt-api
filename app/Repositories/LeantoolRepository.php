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

    public function getAllTools(): Collection
    {
        // TODO: Implement getAllTools() method.
    }

    public function getToolDetails($tool): Collection
    {
        // TODO: Implement getToolDetails() method.
    }

    public function getToolDetailsByName($tool, string $name): Collection
    {
        // TODO: Implement getToolDetailsByName() method.
    }

    public function isArchived($tool): bool
    {
        // TODO: Implement isArchived() method.
    }

}