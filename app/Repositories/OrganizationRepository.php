<?php

namespace App\Repositories;

use App\Models\Organization;
use App\Repositories\Contracts\OrganizationRepositoryInterface;
use Illuminate\Support\Collection;

class OrganizationRepository extends  BaseRepository implements OrganizationRepositoryInterface
{
    public function model()
    {
        return new Organization();
    }

}