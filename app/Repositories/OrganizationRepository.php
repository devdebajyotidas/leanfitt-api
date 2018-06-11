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

    public function getAllOrganization(): Collection
     {
         // TODO: Implement getAllOrganization() method.
     }

     public function getAllOrganizationByUser(): Collection
     {
         // TODO: Implement getAllOrganizationByAdmin() method.
     }

     public function getActiveOrganizations(): Collection
     {
         // TODO: Implement getActiveOrganizations() method.
     }

     public function getArchivedOrganizations(): Collection
     {
         // TODO: Implement getArchivedOrganizations() method.
     }

     public function getOrganizationDepartments($organization): Collection
     {
         // TODO: Implement getOrganizationDepartments() method.
     }

     public function organizationActiveDepartments($organization): Collection
     {
         // TODO: Implement organizationActiveDepartments() method.
     }

     public function organizationArchivedDepartments($organization): Collection
     {
         // TODO: Implement organizationArchivedDepartments() method.
     }

     public function isArchived($organization): bool
     {
         // TODO: Implement isArchived() method.
     }

     public function getSubscription($organization): int
     {
         // TODO: Implement getSubscription() method.
     }
}