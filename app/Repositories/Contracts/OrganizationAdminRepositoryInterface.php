<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

interface OrganizationAdminRepositoryInterface
{
    public function firstOrganizationByAdmin($user_id,$organization=null);

    public function AllOrganizationByAdmin($user);
}