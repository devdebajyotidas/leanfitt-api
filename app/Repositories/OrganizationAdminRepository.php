<?php

namespace App\Repositories;

use App\Models\OrganizationAdmin;
use App\Repositories\Contracts\OrganizationAdminRepositoryInterface;
use Illuminate\Support\Collection;

class OrganizationAdminRepository extends BaseRepository implements OrganizationAdminRepositoryInterface
{
    public function model()
    {
        return new OrganizationAdmin();
    }

    public function getAllOrganizationAdmin(): Collection
    {
        // TODO: Implement getAllOrganizationAdmin() method.
    }

    public function getOrganizationAdmin($organization): Collection
    {
        // TODO: Implement getOrganizationAdmin() method.
    }

    public function AllOrganizationByAdmin($user): Collection
    {
        // TODO: Implement AllOrganizationByAdmin() method.
    }

}