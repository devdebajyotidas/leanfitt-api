<?php

namespace App\Services;

use App\Repositories\AwardRepository;
use App\Services\Contracts\AwardServiceInterface;

class AwardService implements AwardServiceInterface
{
    protected $awardRepository;
    public function __construct(AwardRepository $awardRepository)
    {
        $this->awardRepository=$awardRepository;
    }

    public function addAward($data): bool
    {
        // TODO: Implement addAward() method.
    }
}