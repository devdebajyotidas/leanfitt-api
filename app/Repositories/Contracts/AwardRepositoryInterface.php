<?php

namespace App\Repositories\Contracts;

use App\Models\Department;
use App\Models\Organization;
use Illuminate\Support\Collection;

interface AwardRepositoryInterface
{

      public function getAwards();

}