<?php

namespace App\Services;

use App\Models\Organization;
use App\Repositories\OrganizationRepository;
use App\Services\Contracts\OrganizationServiceInterface;

class OrganizationService implements OrganizationServiceInterface
{
    protected $organizationRepository;
    public function __construct(OrganizationRepository $organizationRepository)
    {
        $this->organizationRepository=$organizationRepository;
    }

    public function addOrganization($data): Organization
    {
        // TODO: Implement addOrganization() method.
    }

    public function updateOrganization($data): bool
    {
        // TODO: Implement updateOrganization() method.
    }

    public function archiveOrganization($organization): bool
    {
        // TODO: Implement archiveOrganization() method.
    }

    public function restoreOrganization($organization): bool
    {
        // TODO: Implement restoreOrganization() method.
    }

    public function removeOrganization($organization): bool
    {
        // TODO: Implement removeOrganization() method.
    }

}