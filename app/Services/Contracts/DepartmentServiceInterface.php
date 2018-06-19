<?php

namespace App\Services\Contracts;


interface DepartmentServiceInterface
{
    public function departments($filter); //eg.organization=id or department=id or null;

    public function addDepartment($request);

    public function updateDepartment($request,$id);

    public function archiveDepartment($id);

    public function restoreDepartment($id);

    public function removeDepartment($id);
}