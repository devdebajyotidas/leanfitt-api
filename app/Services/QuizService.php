<?php

namespace App\Services;

use App\Repositories\AwardRepository;
use App\Repositories\LeantoolRepository;
use App\Repositories\QuizRepository;
use App\Repositories\QuizResultRepository;
use App\Services\Contracts\QuizServiceInterface;
use App\Validators\QuizValidator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class QuizService implements QuizServiceInterface
{
    protected $quizRepo;
    protected $toolRepo;
    protected $awardRepo;
    public function __construct(QuizRepository $quizRepository,
                                LeantoolRepository $leantoolRepository,
                                AwardRepository $awardRepository)
    {
        $this->quizRepo=$quizRepository;
        $this->toolRepo=$leantoolRepository;
        $this->awardRepo=$awardRepository;
    }

    public function index($user_id)
    {
        $response=new \stdClass();
        if(empty($user_id)){
            $response->success=false;
            $response->data=null;
            $response->message="user_id is required";
            return $response;
        }

        $employee_id=$this->quizRepo->getUser($user_id,'employee');
        if($employee_id){
            $query=$this->toolRepo->allQuiz($employee_id);
            $data=$query->map(function($item){
                if(isset($item['quizResult'][0]['id'])){
                  $quiz_taken=true;
                  $score=$item['quizResult'][0]['score'];
                }
                else{
                    $quiz_taken=false;
                    $score=0;
                }
                 return [
                     'tool_id'=>$item['id'],
                     'too_name'=>$item['name'],
                     'question_count'=>count(json_decode($item['quiz'])),
                     'quiz_taken'=>$quiz_taken,
                     'score'=>$score
                 ];
            });

            if($query->count() > 0){
                $response->success=true;
                $response->data=$data;
                $response->message="Quiz found";
            }
            else{
                $response->success=false;
                $response->data=null;
                $response->message="Something went wrong, try again later";
            }
        }
        else{
            $response->success=false;
            $response->data=null;
            $response->message="Something went wrong, try again later";
        }

        return $response;
    }

    public function show($tool_id,$user_id)
    {
        $response=new \stdClass();
        if(empty($user_id)){
            $response->success=false;
            $response->data=null;
            $response->message="user_id is required";
            return $response;
        }

        if(empty($tool_id)){
            $response->success=false;
            $response->data=null;
            $response->message="Please select a tool";
            return $response;
        }

        $employee_id=$this->quizRepo->getUser($user_id,'employee');
        if($employee_id){
            $query=$this->toolRepo->getQuiz($tool_id,$employee_id);
            if($query->count() > 0){
                $quiz=json_decode($query->quiz);
                $data['tool_id']=$query->id;
                $data['tool_name']=$query->name;
                $data['quiz']=$quiz;
                $data['question_count']=count($quiz);
                $data['taken']=count($query->quizResult) > 0 ? true : false;

                $response->success=true;
                $response->data=new Collection($data);
                $response->message="Quiz found";
            }
            else{
                $response->success=false;
                $response->data=null;
                $response->message="Something went wrong, try again later";
            }

        }
        else{
            $response->success=false;
            $response->data=null;
            $response->message="Something went wrong, try again later";
        }

        return $response;
    }

    public function taken($request)
    {
        $response=new \stdClass();
        $organization=$request->get('organization');
        $department=$request->get('department');
        $employee=$request->get('employee');

        $query=$this->quizRepo->allTaken();
        if(!empty($organization)){
            $query=$query->where('organization_id',$organization);
        }

        if(!empty($department)){
            $query=$query->where('department_id',$department);
        }

        if(!empty($employee)){
            $query=$query->where('employee_id',$employee);
        }

        if($query){
            $response->success=true;
            $response->data=$query->orderBy('created_at','desc')->get();
            $response->message="Quiz results found";
        }
        else{
            $response->success=false;
            $response->data=null;
            $response->message="Something went wrong, try again later";
        }

        return $response;
    }

    public function create($request)
    {
        $response=new \stdClass();
        $validator=new QuizValidator($request->all(),'create');
        if($validator->fails()){
            $response->success=false;
            $response->message=$validator->messages()->first();
            return $response;
        }

        DB::beginTransaction();
        $data=$request->all();
        $data['score']=($request->correct/($request->correct+$request->incorrect))*100;
        $query=$this->quizRepo->create($data);
        if($query){
            if($request->incorrect==0){
                $data['title']='Award for quiz';
                $data['type']='quiz';
                $this->awardRepo->create($data);

                DB::commit();
                $response->success=true;
                $response->message="Quiz result has been saved";
            }
            else{
                DB::commit();
                $response->success=true;
                $response->message="Quiz result has been saved";
            }
        }
        else{
            DB::rollBack();
            $response->success=true;
            $response->message="Something went wrong, try again later";
        }

        return $response;
    }

}