<?php

namespace App\Repositories;

use App\Models\Report;
use App\Repositories\Contracts\ReportRepositoryInterface;

class ReportRepository extends BaseRepository implements ReportRepositoryInterface
{
    public function model()
    {
        return new Report();
    }

    public function allReports(){
        return $this->model()->join('projects as p','p.id','=','reports.project_id')
            ->join('report_categories as cat','cat.id','reports.report_category_id')
            ->select(['reports.*','p.organization_id','p.name as project_name','p.report_date','cat.name as report_category']);
    }

    public function showReport($report_id)
    {
        return $this->model()->join('projects as p','p.id','=','reports.project_id')
            ->join('users as leader','leader.id','=','p.leader')
            ->join('users as sensie','sensie.id','=','p.lean_sensie')
            ->join('report_categories as cat','cat.id','reports.report_category_id')
            ->where('reports.id',$report_id)
            ->select([
                'reports.*',
                'cat.name as report_name',
                'p.organization_id',
                'p.id as project_id',
                'p.name as project_name',
                'p.report_date',
                'p.start_date',
                'p.end_date',
                'leader.first_name as leader_first_name',
                'leader.last_name as leader_last_name',
                'leader.id as leader_id',
                'leader.avatar as leader_avatar',
                'sensie.first_name as sensie_first_name',
                'sensie.last_name as sensie_last_name',
                'sensie.id as sensie_id',
                'sensie.avatar as sensie_avatar'
            ])->first();
    }

    public function getCategory($report_id)
    {
        $query=$this->model()->find($report_id);
        return count($query) > 0 ? $query->report_category_id : null;
    }
}