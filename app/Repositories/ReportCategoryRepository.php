<?php

namespace App\Repositories;


use App\Models\ReportCategory;
use App\Repositories\Contracts\ReportCategoryRepositoryInterface;

class ReportCategoryRepository extends BaseRepository implements ReportCategoryRepositoryInterface
{
    public function model()
    {
        return new ReportCategory();
    }

}