<?php

namespace App\Services;

use App\Repositories\LeantoolRepository;
use App\Services\Contracts\LeanToolServiceInterface;

class LeantoolService implements LeanToolServiceInterface
{

    protected $leantoolRepository;
    public function __construct(LeantoolRepository $leantoolRepository)
    {
        $this->leantoolRepository=$leantoolRepository;
    }

    public function addLeanTool($data): bool
    {
        // TODO: Implement addLeanTool() method.
    }

    public function updateLeanTool($data): bool
    {
        // TODO: Implement updateLeanTool() method.
    }

    public function removeLeanTools($tool): bool
    {
        // TODO: Implement removeLeanTools() method.
    }

}