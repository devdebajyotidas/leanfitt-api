<?php

namespace App\Repositories;

use Illuminate\Support\Collection;

interface OrganizationAdminRepositoryInterface
{
    public function getAllOrganizationAdmin():Collection;
    public function getOrganizationAdmin($organization):Collection;
    public function AllOrganizationByAdmin($user):Collection;
}