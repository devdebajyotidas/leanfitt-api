<?php

namespace App\Services\Contracts;


interface DepartmentServiceInterface
{
    public function departments($filter); //eg.organization=id or department=id or null;

    public function list($filter);

    public function details($department_id);

    public function addDepartment($request);

    public function updateDepartment($request,$department_id);

    public function archiveDepartment($department_id);

    public function restoreDepartment($department_id);

    public function removeDepartment($department_id,$user_id);
}