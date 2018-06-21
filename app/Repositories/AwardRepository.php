<?php

namespace App\Repositories;

use App\Models\Award;
use App\Repositories\Contracts\AwardRepositoryInterface;
use Illuminate\Support\Collection;

class AwardRepository extends BaseRepository implements AwardRepositoryInterface
{

    public function model()
    {
        return new Award();
    }

    public function getAllAwards(): Collection
    {
        // TODO: Implement getAllAwards() method.
    }

    public function getAllAwardbyDepartment($department): Collection
    {
        // TODO: Implement getAllAwardbyDepartment() method.
    }

    public function getAllAwardsByUser($user): Collection
    {
        // TODO: Implement getAllAwardsByUser() method.
    }

    public function getAllAwardByOrganization($organization): Collection
    {
        // TODO: Implement getAllAwardByOrganization() method.
    }
}