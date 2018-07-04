<?php

namespace App\Repositories;


use App\Models\ReportReason;
use App\Repositories\Contracts\ReportReasonRepositoryInterface;

class ReportReasonRepository extends BaseRepository implements ReportReasonRepositoryInterface
{
    public function model()
    {
        return new ReportReason();
    }
}