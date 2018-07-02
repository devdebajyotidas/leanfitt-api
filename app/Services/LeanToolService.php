<?php

namespace App\Services;


use App\Repositories\LeantoolRepository;
use App\Services\Contracts\LeanToolServiceInterface;
use App\Validators\LeanToolValidator;
use Illuminate\Support\Facades\DB;

class LeanToolService implements LeanToolServiceInterface
{
    protected $toolRepo;
    public function __construct(LeantoolRepository $leantoolRepository)
    {
        $this->toolRepo=$leantoolRepository;
    }

    public function index()
    {
        $response=new \stdClass();
        $query=$this->toolRepo->all();
        $data=$query->map(function($item){
           return [
               'id'=>$item['id'],
               'name'=>$item['name'],
               'quiz_count'=>count(json_decode($item['quiz'])),
           ];
        });

        if(count($data) > 0){
            $response->success=true;
            $response->data=$data;
            $response->message="Tools found";
        }
        else{
            $response->success=false;
            $response->data=null;
            $response->message="No tools found";
        }

        return $response;
    }

    public function create($request)
    {
        $response=new \stdClass();
        $validator=new LeanToolValidator($request->all(),'create');
        if($validator->fails()){
            $response->success=false;
            $response->message=$validator->messages()->first();
            return $response;
        }

        DB::beginTransaction();
        $query=$this->toolRepo->create($request->all());
        if($query){
            DB::commit();
            $response->success=true;
            $response->message="Lean tool has been added";
        }
        else{
            DB::rollBack();
            $response->success=false;
            $response->message="Something went wrong, try agian later";
        }

        return $response;
    }

    public function update($request, $tool_id)
    {
        $response=new \stdClass();
        if(empty($tool_id)){
            $response->success=false;
            $response->message="Please select a tool to update";
            return $response;
        }

        DB::beginTransaction();
        $query=$this->toolRepo->update($tool_id,$request->all());
        if($query){
            DB::commit();
            $response->success=true;
            $response->message="Lean tool has been updated";
        }
        else{
            DB::rollBack();
            $response->success=false;
            $response->message="Something went wrong, try agian later";
        }

        return $response;
    }

    public function show($tool_id)
    {
        $response=new \stdClass();
        if(empty($tool_id)){
            $response->success=false;
            $response->data=null;
            $response->message="Please select a tool";
            return $response;
        }

        $query=$this->toolRepo->find($tool_id);
        if($query){
            $response->success=true;
            $response->data=$query;
            $response->message="Tool found";
        }
        else{
            $response->success=false;
            $response->data=null;
            $response->message="Tool not found";
        }

        return $response;
    }

    public function delete($tool_id, $user_id)
    {
        $response=new \stdClass();
        if(empty($tool_id)){
            $response->success=false;
            $response->message="tool_id is required";
            return $response;
        }

        if(empty($user_id)){
            $response->success=false;
            $response->message="user_id is required";
            return $response;
        }

        if(!$this->toolRepo->isSuperAdmin($user_id)){
            $response->success=false;
            $response->message="You don't have enough permission";
            return $response;
        }

        DB::beginTransaction();
        $tool=$this->toolRepo->find($tool_id);
        if(count($tool)){
            if($this->toolRepo->forceDeleteRecord($tool)){
                DB::commit();
                $response->success=true;
                $response->message="Lean tool has been deleted";
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
            $response->message="Lean tool not found";
        }
    }
}