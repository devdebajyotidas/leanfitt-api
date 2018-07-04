<?php

namespace App\Repositories;


use App\Models\ReportDefault;
use App\Repositories\Contracts\ReportDefaultsRepositoryInterface;

class ReportDefaultRepository extends BaseRepository implements ReportDefaultsRepositoryInterface
{
    public function model()
    {
        return new ReportDefault();
    }

    public function getDefault($report_id, $level)
    {
        $query=$this->model()->withCount(['assignment'=>function($query) use($report_id,$level){
            $query->where('report_id',$report_id)->where('level',$level);
        }]);
        return $query;
    }
}