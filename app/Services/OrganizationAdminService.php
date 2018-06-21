<?php

namespace App\Services;

use App\Repositories\OrganizationAdminRepository;

class OrganizationAdminService
{
    protected $organizationAdminRepository;
    public function __construct(OrganizationAdminRepository $organizationAdminRepository)
    {
        $this->organizationAdminRepository=$organizationAdminRepository;
    }
}