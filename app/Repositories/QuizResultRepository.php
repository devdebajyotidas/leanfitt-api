<?php

namespace App\Repositories;

use App\Models\Department;
use App\Models\Employee;
use App\Models\QuizResult;
use App\Repositories\Contracts\QuizResultRepositoryInterface;
use Illuminate\Support\Collection;

class QuizResultRepository extends BaseRepository implements QuizResultRepositoryInterface
{

    public function model()
    {
        return new QuizResult();
    }

    public function employee(){
        return new Employee();
    }

    public function getAllQuizTaken(): Collection
    {
        $result=$this->model()->with(['user','tool'])->get();
        return $this->listView($result);
    }

    public function getAllQuizTakenByUser($user): Collection
    {
        $result=$this->model()->with(['user','tool'])->where('user_id',$user)->get();
        return $this->listView($result);
    }

    public function getAllQuizTakenByDepartment($department): Collection
    {
        $ids=$this->employee()->where('department_id',$department)->pluck('user_id')->toArray();
        $result=$this->model()->with(['user','tool'])->whereIn('user_id',$ids)->get();
        return $this->listView($result);
    }

    public function getAllQuizTakenByOrganization($organization): Collection
    {
        $ids=$this->employee()->where('organization_id',$organization)->pluck('user_id')->toArray();
        $result=$this->model()->with(['user','tool'])->whereIn('user_id',$ids)->get();
        return $this->listView($result);
    }

    public function getQuizResult($quizTaken)
    {
        $result=$this->model()->find($quizTaken);
        return $result;
    }

    /*Additional*/

    function listView($result){
         $data=$result->map(function($item){
            return [
                'tool_id'=>$item['lean_tool_id'],
                'tool_name'=>$item['tool']['name'],
                'user_name'=>$item['user']['first_name'] .' '.$item['user']['last_name'],
                'user_id'=>$item['user_id'],
                'user_avatar'=>$item['user']['avatar'],
                'score'=>$item['score'],
                'created_at'=>$item['created_at'],
                'is_completed'=>$item['is_completed'],
            ] ;
         });

         return $data;
    }
}