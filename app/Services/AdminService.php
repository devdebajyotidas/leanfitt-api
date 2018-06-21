<?php

namespace App\Services;

use App\Repositories\AdminRepository;

class AdminService
{

    protected $adminRepository;
    public function __construct(AdminRepository $adminRepository)
    {
        $this->adminRepository=$adminRepository;
    }
}