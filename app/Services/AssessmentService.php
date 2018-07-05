<?php

namespace App\Services;


use App\Repositories\AssessmentRepository;
use App\Repositories\LeantoolRepository;
use App\Services\Contracts\AssessmentServiceInterface;
use App\Validators\AssessmentResultValidator;
use Illuminate\Support\Carbon;

class AssessmentService implements AssessmentServiceInterface
{
    protected $repo;
    protected $toolRepo;
    public function __construct(AssessmentRepository $assessmentRepository,
                                LeantoolRepository $leantoolRepository)
    {
        $this->repo=$assessmentRepository;
        $this->toolRepo=$leantoolRepository;
    }

    public function index($user_id)
    {
        $response=new \stdClass();

        if(empty($user_id)){
            $response->success=false;
            $response->data=null;
            $response->message="User id field is required";
            return $response;
        }

        $employee_id=$this->toolRepo->getEmployee($user_id);
        if(empty($employee_id)){
            $response->success=false;
            $response->data=null;
            $response->message="User not found";
            return $response;
        }

        $query=$this->toolRepo->allAssessment($employee_id);
        if(count($query) > 0){
            $data=$query->map(function($item){
                $updated=count($item['assessmentResult']) > 0 ?  Carbon::parse(($item['assessmentResult']->first())->updated_at)->format('Y-m-d H:i:s') : null;
                return [
                    'tool_id'=>$item['id'],
                    'tool_name'=>$item['name'],
                    'tool_image'=>$item['featured_image'],
                    'assessment_count'=>count(json_decode($item['assessment'])),
                    'assessment_result_count'=>count($item['assessmentResult']),
                    'last_result_update'=>$updated,
                ];
            });
            $response->success=true;
            $response->data=$data;
            $response->message="Assessment found";
        }
        else{
            $response->success=false;
            $response->data=null;
            $response->message="No assessment found";
        }

        return $response;
    }


    public function list($request)
    {
        $response=new \stdClass();
        $organization=$request->get('organization');
        $department=$request->get('department');
        $user=$request->get('user');
        $employee=$request->get('employee');
        $tool=$request->get('tool');

        $query=$this->repo->allAssessment();
        if(!empty($organization)){
            $query=$query->where('organization_id',$organization);
        }
        if(!empty($department)){
            $query=$query->where('department_id',$department);
        }
        if(!empty($user)){
            $query=$query->where('user_id',$user);
        }
        if(!empty($employee)){
            $query=$query->where('employee_id',$employee);
        }
        if(!empty($tool)){
            $query=$query->where('lean_tool_id',$tool);
        }
        $query=$query->get();

        if(count($query) > 0){
            $response->success=true;
            $response->data=$query;
            $response->message="Assessment found";
        }
        else{
            $response->success=false;
            $response->data=null;
            $response->message="No assessment result found";
        }

        return $response;
    }


    public function show($tool_id, $user_id)
    {
        $response=new \stdClass();

        if(empty($user_id)){
            $response->success=false;
            $response->data=null;
            $response->message="User id field is required";
            return $response;
        }

        if(empty($tool_id)){
            $response->success=false;
            $response->data=null;
            $response->message="Tool id field is required";
            return $response;
        }

        $employee_id=$this->toolRepo->getEmployee($user_id);
        if(empty($employee_id)){
            $response->success=false;
            $response->data=null;
            $response->message="User not found";
            return $response;
        }

        $query=$this->toolRepo->getAssessment($tool_id,$employee_id);
        if(count($query) > 0){
            $response->success=true;
            $response->data=$query;
            $response->message="Assessment found";
        }
        else{
            $response->success=false;
            $response->data=null;
            $response->message="No assessment found";
        }

        return $response;
    }

    public function create($request)
    {
        $response=new \stdClass();
        $validator=new AssessmentResultValidator($request->all(),'create');
        if($validator->fails()){
            $response->success=false;
            $response->message=$validator->messages()->first();
            return $response;
        }

        $query=$this->repo->create($request->all());
        if($query){
            $response->success=true;
            $response->message="Assessment result added";
        }
        else{
            $response->success=false;
            $response->message="Something went wrong, try again later";
        }

        return $response;
    }
}