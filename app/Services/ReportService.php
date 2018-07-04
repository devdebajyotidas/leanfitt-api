<?php

namespace App\Services;


use App\Repositories\ReportCategoryRepository;
use App\Repositories\ReportChartAxesRepository;
use App\Repositories\ReportChartRepository;
use App\Repositories\ReportDefaultAssignmentRepository;
use App\Repositories\ReportDefaultRepository;
use App\Repositories\ReportElementAssignemtnRepository;
use App\Repositories\ReportElementRepository;
use App\Repositories\ReportGridRepository;
use App\Repositories\ReportProblemRepository;
use App\Repositories\ReportReasonRepository;
use App\Repositories\ReportRepository;
use App\Services\Contracts\ReportServiceInterface;
use App\Validators\ReportAssignmentValidator;
use App\Validators\ReportChartValidator;
use App\Validators\ReportDefaultValidator;
use App\Validators\ReportElementAssignmentValidator;
use App\Validators\ReportElementValidator;
use App\Validators\ReportGridValidator;
use App\Validators\ReportValidator;
use Illuminate\Support\Facades\DB;

class ReportService implements ReportServiceInterface
{
    protected $reportRepo;
    protected $categoryRepo;
    protected $chartRepo;
    protected $chartAxisRepo;
    protected $gridRepo;
    protected $defaultRepo;
    protected $defaultAssignmentRepo;
    protected $elementRepo;
    protected $elementAssignmentRepo;
    protected $problemRepo;
    protected $reasonRepo;
    public function __construct(ReportRepository $reportRepository,
                                ReportCategoryRepository $categoryRepository,
                                ReportChartRepository $reportChartRepository,
                                ReportChartAxesRepository $chartAxesRepository,
                                ReportGridRepository $gridRepository,
                                ReportDefaultRepository $defaultRepository,
                                ReportDefaultAssignmentRepository $assignmentRepository,
                                ReportElementRepository $elementRepository,
                                ReportElementAssignemtnRepository $elementAssignemtnRepository,
                                ReportProblemRepository $problemRepository,
                                ReportReasonRepository $reasonRepository)
    {
        $this->reportRepo=$reportRepository;
        $this->categoryRepo=$categoryRepository;
        $this->chartRepo=$reportChartRepository;
        $this->chartAxisRepo=$chartAxesRepository;
        $this->gridRepo=$gridRepository;
        $this->defaultRepo=$defaultRepository;
        $this->defaultAssignmentRepo=$assignmentRepository;
        $this->elementRepo=$elementRepository;
        $this->elementAssignmentRepo=$elementAssignemtnRepository;
        $this->problemRepo=$problemRepository;
        $this->reasonRepo=$reasonRepository;
    }

    public function index($request)
    {
        $response=new \stdClass();
        $organization=$request->get('organization');
        $project=$request->get('project');

        $query=$this->reportRepo->allReports();
        if(!empty($organization)){
            $query=$query->where('organization_id',$organization);
        }

        if(!empty($project)){
            $query=$query->where('project_id',$project);
        }

        $query=$query->get();

        if(count($query) > 0){
            $response->success=true;
            $response->data=$query;
            $response->message="Reports found";
        }
        else{
            $response->success=false;
            $response->data=null;
            $response->message="No report found";
        }

        return $response;
    }

    public function names()
    {
        $response=new \stdClass();
        $query=$this->categoryRepo->all();
        if(count($query) > 0){
            $response->success=true;
            $response->data=$query;
            $response->message="Categories found";
        }
        else{
            $response->success=false;
            $response->data=$query;
            $response->message="No category found";
        }

        return $response;
    }

    public function create($request)
    {
        $response=new \stdClass();
        $validator=new ReportValidator($request->all(),'create');
        if($validator->fails()){
            $response->success=false;
            $response->message=$validator->messages()->first();
            return $response;
        }

        DB::beginTransaction();
        $query=$this->reportRepo->create($request->all());
        if($query){
            DB::commit();
            $response->success=true;
            $response->message="Report has been added";
        }
        else{
            DB::rollBack();
            $response->success=false;
            $response->message="Something went wrong, try again later";
        }

        return $response;
    }

    public function show($report_id)
    {
        $response=new \stdClass();

        if(empty($report_id)){
            $response->success=false;
            $response->data=null;
            $response->message="Report id field is required";
        }

        $query=$this->reportRepo->showReport($report_id);
        if(count($query) > 0){
            $response->success=true;
            $response->data=$query;
            $response->message="Reports found";
        }
        else{
            $response->success=false;
            $response->data=null;
            $response->message="No report found";
        }

        return $response;
    }

    public function delete($report_id,$user_id)
    {
        $response=new \stdClass();
        if(empty($report_id)){
            $response->success=false;
            $response->message="Report id field is required";
            return $response;
        }

        if(empty($user_id)){
            $response->success=false;
            $response->message="User id field is required";
            return $response;
        }

        DB::beginTransaction();
        $report=$this->reportRepo->find($report_id);
        if(count($report)){
            if($report->created_by==$user_id || $this->reportRepo->isAdmin($user_id) || $this->reportRepo->isSuperAdmin($user_id)){
                $delete=$this->reportRepo->forceDeleteRecord($report);
                if($delete){
                    DB::commit();
                    $response->success=true;
                    $response->message="Report has been deleted";
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
                $response->message="You don't have enough permission to delete this repo";
            }
        }
        else{
            DB::rollBack();
            $response->success=false;
            $response->message="Report not found";
        }

        return $response;
    }

    public function showGridData($report_id)
    {
        $response=new \stdClass();

        if(empty($report_id)){
            $response->success=false;
            $response->data=null;
            $response->message="Report id field is required";
            return $response;
        }

        $query=$this->gridRepo->allGrids($report_id);
        if(count($query) > 0){
            $response->success=true;
            $response->data=$query->groupBy('position');
            $response->message="Data found";
        }
        else{
            $response->success=false;
            $response->data=null;
            $response->message="No data found";
        }

        return $response;
    }

    public function createGridData($request)
    {
        $response=new \stdClass();
        $validator=new ReportGridValidator($request->all(),'create');
        if($validator->fails()){
            $response->success=false;
            $response->message=$validator->messages()->first();
            return $response;
        }

        DB::beginTransaction();
        $query=$this->gridRepo->create($request->all());
        if($query){
            DB::commit();
            $response->success=true;
            $response->message="Data has been added";
        }
        else{
            DB::rollBack();
            $response->success=false;
            $response->message="Something went wrong, try again later";
        }

        return $response;
    }

    public function deleteGridData($grid_id)
    {
        $response=new \stdClass();
        if(empty($grid_id)){
            $response->success=false;
            $response->message="Grid id field is required";
            return $response;
        }

        DB::beginTransaction();
        $grid=$this->gridRepo->find($grid_id);
        if(count($grid) > 0){
             $query=$this->gridRepo->forceDeleteRecord($grid);
             if($query){
                 DB::commit();
                 $response->success=true;
                 $response->message="Data has been deleted";
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
            $response->message="Requested data not found";
        }

        return $response;
    }

    public function showChartData($report_id)
    {
        $response=new \stdClass();
        if(empty($report_id)){
            $response->success=false;
            $response->data=null;
            $response->message="Report id field is required";
            return $response;
        }

        $query=$this->chartAxisRepo->getChart($report_id);

        if(count($query) > 0){
            $response->success=true;
            $response->data=$query;
            $response->message="Data found";
        }
        else{
            $response->success=false;
            $response->data=null;
            $response->message="No data found";
        }

        return $response;
    }

    public function createChartData($request)
    {
        $response=new \stdClass();
        $validator=new ReportChartValidator($request->all(),'create');
        if($validator->fails()){
            $response->success=false;
            $response->message=$validator->messages()->first();
            return $response;
        }

        $query=$this->chartRepo->create($request->all());
        if($query){
            $chartaxes=$this->chartAxisRepo->create(['x'=>'x axis','y'=>'y axis','report_id'=>$request->report_id]);
            if($chartaxes){
                $response->success=true;
                $response->message="Data has been added";
            }
            else{
                $response->success=false;
                $response->message="Something went wrong, try again later";
            }
        }
        else{
            $response->success=false;
            $response->message="Something went wrong, try again later";
        }

        return $response;

    }

    public function deleteChartData($chart_id)
    {
        $response=new \stdClass();

        if(empty($chart_id)){
            $response->success=false;
            $response->message="chart_id is required";
            return $response;
        }

        DB::beginTransaction();
        $chart=$this->chartRepo->find($chart_id);
        if(count($chart)){
            $query=$this->chartRepo->forceDeleteRecord($chart);
            if($query){
                DB::commit();
                $response->success=true;
                $response->message="Data has been deleted";
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
            $response->message="Chart data not found";
        }

        return $response;
    }

    public function changeChartAxis($request,$report_id)
    {
        $response=new \stdClass();
        if(empty($request->all())){
            $response->success=false;
            $response->message="Can't add the empty data";
            return $response;
        }

        if(empty($report_id)){
            $response->success=false;
            $response->message="chart_id is required";
            return $response;
        }

        DB::beginTransaction();
        $chart=$this->chartAxisRepo->where('report_id',$report_id)->first();
        if(count($chart) > 0){
            $update=$this->chartAxisRepo->fillUpdate($chart,$request->all());
            if($update){
                DB::commit();
                $response->success=true;
                $response->message="Axis name has been changed";
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
            $response->message="Chart not found";
        }

        return $response;
    }

    public function showDefaultData($requets, $report_id,$level)
    {
        $response=new \stdClass();
        if(empty($report_id)){
            $response->success=false;
            $response->data=null;
            $response->message="Report id field is required";
            return $response;
        }

        $level=empty($level) ? 1 : $level;
        $type=$requets->get('type');
        $category_id=$this->reportRepo->getCategory($report_id);

        $query=$this->defaultRepo->getDefault($report_id,$level);

        if(!empty($type)){
            $query=$query->where('type',$type);
        }

        if(!empty($category_id)){
            $query=$query->where('report_category_id',$category_id);
        }

        $query=$query->get();
        if(count($query) > 0){
            $response->success=true;
            $response->data=$query;
            $response->message="Data found";
        }
        else{
            $response->success=false;
            $response->data=null;
            $response->message="No data found";
        }

        return $response;
    }

    public function showDefaultElementData($request, $default_id,$report_id)
    {
        $response=new \stdClass();
        if(empty($default_id)){
            $response->success=false;
            $response->data=null;
            $response->message="Default id field is required";
            return $response;
        }
        $sort=$request->get('sort');

        $query=$this->elementRepo->getElements($default_id,$report_id);
        if(!empty($sort)){
            $query=$query->where('sort',$sort);
        }

        $query=$query->get();
        if(count($query) > 0){
            $response->success=true;
            $response->data=$query;
            $response->message="Data found";
        }
        else{
            $response->success=false;
            $response->data=null;
            $response->message="No data found";
        }

        return $response;
    }

    public function createDefaultData($request)
    {
        $response=new \stdClass();

        if(empty($request->get('report_category_id')) && empty($request->get('report_id'))){
            $response->success=false;
            $response->message="Report id field is required";
            return $response;
        }

        $data=$request->all();
        if(empty($request->get('report_category_id'))){
            $data['report_category_id']=$this->reportRepo->getCategory($request->report_id);
        }else{
            $data['report_category_id']=$request->get('report_category_id');
        }

        $validator=new ReportDefaultValidator($data,'create');
        if($validator->fails()){
            $response->success=false;
            $response->message=$validator->messages()->first();
            return $response;
        }

        DB::beginTransaction();
        $query=$this->defaultRepo->create($data);
        if($query){
            DB::commit();
            $response->success=true;
            $response->message="Data has been added";
        }
        else{
            DB::rollBack();
            $response->success=false;
            $response->message="Something went wrong, try again later";
        }

        return $response;
    }

    public function createDefaultElementData($request)
    {
        $response=new \stdClass();
        $validator=new ReportElementValidator($request->all(),'create');
        if($validator->fails()){
            $response->success=false;
            $response->message=$validator->messages()->first();
            return $response;
        }

        DB::beginTransaction();
        $query=$this->elementRepo->create($request->all());
        if($query){
            DB::commit();
            $response->success=true;
            $response->message="Data has been added";
        }
        else{
            DB::rollBack();
            $response->success=false;
            $response->message="Something went wrong, try again later";
        }

        return $response;

    }

    public function deleteDefaultData($default_id)
    {
        $response=new \stdClass();
        if(empty($default_id)){
            $response->success=false;
            $response->message="Default id field is required";
            return $response;
        }

        DB::beginTransaction();
        $default=$this->defaultRepo->find($default_id);
        if(count($default) > 0){
            $query=$this->defaultRepo->forceDeleteRecord($default);
            if($query){
                DB::commit();
                $response->success=true;
                $response->message="Data has been deleted";
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
            $response->message="Data not found";
        }

        return $response;
    }

    public function deleteDefaultElementData($element_id)
    {
        $response=new \stdClass();
        if(empty($element_id)){
            $response->success=false;
            $response->message="Element id field is required";
            return $response;
        }

        DB::beginTransaction();
        $default=$this->elementRepo->find($element_id);
        if(count($default) > 0){
            $query=$this->elementRepo->forceDeleteRecord($default);
            if($query){
                DB::commit();
                $response->success=true;
                $response->message="Data has been deleted";
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
            $response->message="Data not found";
        }

        return $response;
    }

    public function showDefaultAssignments($report_id, $level)
    {
        $response=new \stdClass();
        if(empty($report_id)){
            $response->success=false;
            $response->data=null;
            $response->message="Report id field is required";
            return $response;
        }

        $query=$this->defaultAssignmentRepo->getAssignments($report_id);
        if(empty($level)){
            $query=$query->where('report_default_assignments.level',1);
        }
        else{
            $query=$query->where('report_default_assignments.level',$level);
        }

        $query=$query->get();
        if(count($query) > 0){
            $response->success=true;
            $response->data=$query;
            $response->message="Data found";
        }
        else{
            $response->success=false;
            $response->data=null;
            $response->message="No data found";
        }

        return $response;
    }

    public function showElementAssignments($default_id, $level)
    {
        $response=new \stdClass();
        if(empty($default_id)){
            $response->success=false;
            $response->data=null;
            $response->message="Default id field is required";
            return $response;
        }

        $query=$this->elementAssignmentRepo->getAssignments($default_id);
        if(empty($level)){
            $query=$query->where('report_element_assignments.level',1);
        }
        else{
            $query=$query->where('report_element_assignments.level',$level);
        }

        $query=$query->get();
        if(count($query) > 0){
            $response->success=true;
            $response->data=$query;
            $response->message="Data found";
        }
        else{
            $response->success=false;
            $response->data=null;
            $response->message="No data found";
        }

        return $response;
    }

    public function createDefaultAssignments($request)
    {
        $response=new \stdClass();
        $validator=new ReportAssignmentValidator($request->all(),'create');
        if($validator->fails()){
            $response->success=false;
            $response->message=$validator->messages()->first();
            return $response;
        }

        DB::beginTransaction();
        $query=$this->defaultAssignmentRepo->create($request->all());
        if($query){
            DB::commit();
            $response->success=true;
            $response->message="Data has been added";
        }
        else{
            DB::rollBack();
            $response->success=false;
            $response->message="Something went wrong, try again later";
        }

        return $response;
    }

    public function createElementAssignments($request)
    {
        $response=new \stdClass();
        $validator=new ReportElementAssignmentValidator($request->all(),'create');
        if($validator->fails()){
            $response->success=false;
            $response->message=$validator->messages()->first();
            return $response;
        }

        DB::beginTransaction();
        $query=$this->elementAssignmentRepo->create($request->all());
        if($query){
            DB::commit();
            $response->success=true;
            $response->message="Data has been added";
        }
        else{
            DB::rollBack();
            $response->success=false;
            $response->message="Something went wrong, try again later";
        }

        return $response;
    }

    public function deleteDefaultAssignments($default_id)
    {
        $response=new \stdClass();
        if(empty($default_id)){
            $response->success=false;
            $response->message="Default id field is required";
            return $response;
        }

        DB::beginTransaction();
        $default=$this->defaultAssignmentRepo->find($default_id);
        if(count($default) > 0){
            $query=$this->defaultAssignmentRepo->forceDeleteRecord($default);
            if($query){
                DB::commit();
                $response->success=true;
                $response->message="Data has been deleted";
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
            $response->message="Data not found";
        }

        return $response;
    }

    public function deleteElementAssignments($assignment_id)
    {
        $response=new \stdClass();
        if(empty($assignment_id)){
            $response->success=false;
            $response->message="Assignment id field is required";
            return $response;
        }

        DB::beginTransaction();
        $default=$this->elementAssignmentRepo->find($assignment_id);
        if(count($default) > 0){
            $query=$this->elementAssignmentRepo->forceDeleteRecord($default);
            if($query){
                DB::commit();
                $response->success=true;
                $response->message="Data has been deleted";
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
            $response->message="Data not found";
        }

        return $response;
    }

    public function showFive($report_id)
    {
        $response=new \stdClass();
        if(empty($report_id)){
            $response->success=false;
            $response->data=null;
            $response->message="Report id field is required";
            return $response;
        }
        $query=$this->problemRepo->getProblems($report_id);
        if(count($query) > 0){
            $response->success=true;
            $response->data=$query;
            $response->message="Data found";
        }
        else{
            $response->success=false;
            $response->data=null;
            $response->message="No data found";
        }

        return $response;
    }

//    public function showFiveWhy($report_id)
//    {
//        $response=new \stdClass();
//        if(empty($report_id)){
//            $response->success=false;
//            $response->message="Report id field is required";
//            return $response;
//        }
//    }

    public function createFive($request)
    {
        $response=new \stdClass();
        if(empty($request->all())){
            $response->success=false;
            $response->message="Can't add the empty data";
            return $response;
        }

        DB::beginTransaction();
        $query=$this->problemRepo->create($request->all());
        if($query){
            DB::commit();
            $response->success=true;
            $response->message="New problem has been added";
        }
        else{
            DB::rollBack();
            $response->success=false;
            $response->message="Something went wrong, try again later";
        }

        return $response;
    }

    public function createFiveWhy($request)
    {
        $response=new \stdClass();

        if(empty($request->all())){
            $response->success=false;
            $response->message="Can't add the empty data";
            return $response;
        }

        DB::beginTransaction();
        $query=$this->reasonRepo->create($request->all());
        if($query){
            DB::commit();
            $response->success=true;
            $response->message="Data has been added";
        }
        else{
            DB::rollBack();
            $response->success=false;
            $response->message="Something went wrong, try again later";
        }

        return $response;
    }

    public function deleteFive($problem_id)
    {
        $response=new \stdClass();
        if(empty($problem_id)){
            $response->success=false;
            $response->message="Problem id field is required";
            return $response;
        }

        DB::beginTransaction();
        $default=$this->problemRepo->find($problem_id);
        if(count($default) > 0){
            $query=$this->problemRepo->forceDeleteRecord($default);
            if($query){
                DB::commit();
                $response->success=true;
                $response->message="Data has been deleted";
            }
            else{
                DB::rollBack();
                $response->success=false;
                $response->message="Something went wrong, try again later";
            }
        }
        else{
            $response->success=false;
            $response->message="Data not found";
        }

        return $response;

    }

    public function deleteFiveWhy($reason_id)
    {
        $response=new \stdClass();
        if(empty($reason_id)){
            $response->success=false;
            $response->message="Reason field is required";
            return $response;
        }

        DB::beginTransaction();
        $default=$this->reasonRepo->find($reason_id);
        if(count($default) > 0){
            $query=$this->reasonRepo->forceDeleteRecord($default);
            if($query){
                DB::commit();
                $response->success=true;
                $response->message="Data has been deleted";
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
            $response->message="Data not found";
        }

        return $response;
    }
}