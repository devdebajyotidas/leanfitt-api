<?php

namespace App\Repositories\Contracts;


use App\Models\Employee;
use App\Models\Organization;
use Illuminate\Support\Collection;

interface OrganizationRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getAllOrganization():Collection;

    /**
     * @return Collection
     */
    public function getAllOrganizationByAdmin():Collection;

    /**
     * @return Collection
     */
    public function getActiveOrganizations():Collection;

    /**
     * @return Collection
     */
    public function getArchivedOrganizations():Collection;

    /**
     * @param int|Organization $organization
     * @return Collection
     */
    public function getOrganizationDepartments($organization):Collection;

    /**
     * @param int|Organization $organization
     * @return Collection
     */
    public function organizationActiveDepartments($organization):Collection;

    /**
     * @param int|Organization $organization
     * @return Collection
     */
    public function organizationArchivedDepartments($organization):Collection;

    /**
     * @param int|Organization $organization
     * @return bool
     */
    public function isArchived($organization):bool;

    /**
     * @param int|Organization $organization
     * @return integer
     */
    public function countSubscription($organization):int ;

}