<?php

namespace App\Repositories;


use App\Models\ReportDefaultElement;
use App\Repositories\Contracts\ReportElementRepositoryInterface;

class ReportElementRepository extends BaseRepository implements ReportElementRepositoryInterface
{
    public function model()
    {
        return new ReportDefaultElement();
    }

    public function getElements($default_id,$report_id){
        $query=$this->model()->withCount(['assignment'=>function($query) use($default_id,$report_id){
            $query->where('report_default_id',$default_id)->where('report_id',$report_id);
        }])->where('report_default_id',$default_id);
        return $query;
    }
}