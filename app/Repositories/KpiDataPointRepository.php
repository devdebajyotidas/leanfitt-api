<?php

namespace App\Repositories;


use App\Models\KpiDataPoint;
use App\Repositories\Contracts\KpiDataPointRepositoryInterface;

class KpiDataPointRepository extends BaseRepository implements KpiDataPointRepositoryInterface
{
    public function model()
    {
        return new KpiDataPoint();
    }

   /*Add*/

    /*Remove*/
}