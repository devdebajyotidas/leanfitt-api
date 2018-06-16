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

    public function getAllAwardbyDepartment($department): Collection
    {
         $results=$this->model()->all();
         return new Collection($results);
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