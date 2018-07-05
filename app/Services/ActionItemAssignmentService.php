<?php

namespace App\Services;


use App\Repositories\ActionItemAssignmentRepository;
use App\Services\Contracts\ActionItemAssignmentServiceInterface;

class ActionItemAssignmentService implements ActionItemAssignmentServiceInterface
{
    protected $aiaRepo;
    public function __construct(ActionItemAssignmentRepository $itemAssignmentRepository)
    {
        $this->aiaRepo=$itemAssignmentRepository;
    }
}