<?php

namespace App\Services\Contracts;


interface OrganizationServiceInterface
{
    public function all();

    public function details($organization);

    public function changeAdmin($user_id,$org);

    public function list();

    public function updateOrganization($request,$org);

    public function removeOrganization($org_id,$user_id);
}