<?php

namespace App\Services\Contracts;

use App\Models\Department;

interface DepartmentServiceInterface
{

    /**
     * @param $data
     * @return bool
     */
    public function addDepartment($data):bool;

    /**
     * @param $data
     * @return bool
     */
    public function updateDepartment($data):bool;

    /**
     * @param int|Department $department
     * @return bool
     */
    public function archiveDepartment($department):bool;

    /**
     * @param int|Department $department
     * @return bool
     */
    public function restoreDepartment($department):bool;

    /**
     * @param int|Department $department
     * @return bool
     */
    public function removeDepartment($department):bool;

}