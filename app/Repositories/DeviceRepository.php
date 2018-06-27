<?php

namespace App\Repositories;

use App\Models\Device;
use App\Repositories\Contracts\DeviceRepositoryInterface;

class DeviceRepository extends BaseRepository implements DeviceRepositoryInterface
{

    public function model()
    {
        return new Device();
    }

}