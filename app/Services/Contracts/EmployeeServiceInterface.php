<?php

namespace App\Services\Contracts;


interface EmployeeServiceInterface
{
    public function index($request);

    public function show($employee_id);

    public function changeDepartment($request);

    public function list($request);

    public function invite($request);

    public function resend($invitation_id);

    public function join($request);

    public function archive($employee_id);

    public function restore($employee_id);

    public function delete($employee_id);

    public function subscribe($employee_id);
}