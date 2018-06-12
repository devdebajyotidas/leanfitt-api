<?php

namespace App\Services\Contracts;

use App\Models\Organization;

interface OrganizationServiceInterface
{
    /**
     * @param $data
     * @return Organization
     */
    public function addOrganization($data):Organization;

    /**
     * @param $data
     * @return bool
     */
    public function updateOrganization($data):bool;

    /**
     * @param int|Organization $organization
     * @return bool
     */
    public function archiveOrganization($organization):bool;

    /**
     * @param int|Organization $organization
     * @return bool
     */
    public function restoreOrganization($organization):bool;

    /**
     * @param int|Organization $organization
     * @return bool
     */
    public function removeOrganization($organization):bool;
}