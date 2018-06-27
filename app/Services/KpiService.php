<?php

namespace App\Services;


use App\Repositories\KpiDataPointRepository;
use App\Repositories\KPIRespository;
use App\Services\Contracts\KpiServiceInterface;
use App\Validators\KpiDataValidator;
use App\Validators\KpiValidator;
use Carbon\Carbon;

class KpiService implements KpiServiceInterface
{
    protected $kpiRepo;
    protected $kpiDataRepo;
    public function __construct(KPIRespository $KPIRespository,KpiDataPointRepository $kpiDataPointRepository)
    {
        $this->kpiRepo=$KPIRespository;
        $this->kpiDataRepo=$kpiDataPointRepository;
    }

    public function index($request)
    {
        $response=new \stdClass();
        $project=$request->get('project');
        $organization=$request->get('organization');

        $query=$this->kpiRepo->allKpi();

        if(!empty($project)){
            $query=$query->where('project_id',$project);
        }

        if(!empty($organization)){
            $query=$query->where('organization_id',$organization);
        }

        $query=$query->get();

        if(count($query) > 0){
            $response->success=true;
            $response->data=$query;
            $response->message="Kpis found";
        }
        else{
            $response->success=false;
            $response->data=null;
            $response->message="Kpis not found";
        }

        return $response;
    }

    public function show($kpi_id)
    {
        $response=new \stdClass();
        if(empty($kpi_id)){
            $response->success=false;
            $response->data=null;
            $response->message="Invalid kpi selection";
            return $response;
        }

        $query=$this->kpiRepo->with(['project','kpiData'])->find($kpi_id);
        if($query){
            $data['id']=$query['id'];
            $data['title']=$query['title'];
            $data['x_label']=$query['x_label'];
            $data['y_label']=$query['y_label'];
            $data['start_date']=$query['end_date'];
            $data['end_date']=$query['start_date'];
            $data['project_id']=isset($query['project']['id']) ?  $query['project']['id'] : null;
            $data['project_name']=isset($query['project']['id']) ?  $query['project']['name'] : null;
            $data['project_start']=isset($query['project']['id']) ?  $query['project']['end_date'] : null;
            $data['project_end']=isset($query['project']['id']) ?  $query['project']['start_date'] : null;
            $data['points']=isset($query['kpiData']) ? $query['kpiData'] : null ;
            $data['created_at']=Carbon::parse($query['created_at'])->format('Y-m-d H:i:s');

            $response->success=true;
            $response->data=$data;
            $response->message="Kpi found";
        }
        else{
            $response->success=false;
            $response->data=null;
            $response->message="Kpi not found";
        }

        return $response;
    }

    public function create($request)
    {
        $response=new \stdClass();
        $validator=new KpiValidator($request->all(),'create');
        if($validator->fails()){
            $response->success=false;
            $response->message=$validator->messages()->first();
            return $response;
        }

        $query=$this->kpiRepo->create($request->all());

        if($query){
             $response->success=true;
             $response->message="Kpi has been added";
        }
        else{
            $response->success=false;
            $response->message="Something went wrong, try again later";
        }

        return $response;
    }

    public function update($request, $kpi_id)
    {
        $response=new \stdClass();
        if(empty($kpi)){
           $response->success=false;
           $response->message="Invalid kpi selection";
           return $response;
        }

        $query=$this->kpiRepo->update($kpi,$request->all());

        if($query){
            $response->success=true;
            $response->message="Kpi has been updated";
        }
        else{
            $response->success=false;
            $response->message="Something went wrong, try again later";
        }

        return $response;
    }

    public function delete($kpi_id, $user_id)
    {
        // TODO: Implement delete() method.
    }

    public function addDataPoint($request)
    {
        $response=new \stdClass();
        $validator=new KpiDataValidator($request->all(),'create');
        if($validator->fails()){
            $response->success=false;
            $response->message=$validator->messages()->first();
            return $response;
        }

        $query=$this->kpiDataRepo->create($request->all());
        if($query){
            $response->success=true;
            $response->message="Kpi datapoint has been added";
        }
        else{
            $response->success=false;
            $response->message="Something went wrong, try again later";
        }

        return $response;
    }

    public function filterDataPoint($request)
    {
        $response=new \stdClass();
        $start=$request->get('start');
        $end=$request->get('end');
        $kpi_id=$request->get('kpi_id');

        if(empty($start) || empty($end)){
            $response->success=false;
            $response->data=null;
            $response->message="Please enter valid date range";
            return $response;
        }

        if(empty($kpi_id)){
            $response->success=false;
            $response->data=null;
            $response->message="kpi_id is required";
            return $response;
        }

        $query=$this->kpiDataRepo->filterDataPoint(Carbon::parse($start)->format('Y-m-d'),Carbon::parse($end)->format('Y-m-d'),$kpi_id);
        if(count($query) > 0){
            $response->success=true;
            $response->data=$query;
            $response->message="Kpi datapoints found";
        }
        else{
            $response->success=false;
            $response->data=null;
            $response->message="No datapoint available";
        }

        return $response;
    }

    public function deleteDatapoint($point_id, $user_id)
    {
        $response=new \stdClass();
        if(empty($point_id)){
            $response->success=false;
            $response->message="Invalid datapoint selection";
            return $response;
        }

        if(empty($user_id)){
            $response->success=false;
            $response->message="user_id is required";
            return $response;
        }

        DB::beginTransaction();
        $point=$this->kpiDataRepo->find($point_id);
        if($point){
            if($point->created_by==$user_id || $this->kpiDataRepo->isAdmin($user_id) || $this->kpiDataRepo->isSuperAdmin($user_id)){
                $query=$this->kpiDataRepo->deleteQuery($point);
                if($query){
                    DB::commit();
                    $response->success=true;
                    $response->message="Data point has been deleted";
                }
                else{
                    DB::rollBack();
                    $response->success=false;
                    $response->message="Something went wrong, try again later";
                }
            }
            else{
                DB::rollBack();
                $response->success=false;
                $response->message="You don't have enough permission to delete the data point";
            }
        }
        else{
            DB::rollBack();
            $response->success=false;
            $response->message="Data point not found";
        }

        return $response;
    }
}