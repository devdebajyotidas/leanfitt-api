<?php

namespace App\Http\Controllers\API;

use App\Services\ActionItemService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ActionItemController extends Controller
{
    protected $service;
    public function __construct(ActionItemService $actionItemService)
    {
        $this->service=$actionItemService;
    }

    public function index(Request $request,$type){
        try{
            $result=$this->service->index($request,$type);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }

    public function show($item_id){
        try{
            $result=$this->service->show($item_id);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }

    public function create(Request $request){
        try{
            $result=$this->service->create($request);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }

    public function update(Request $request,$tool_id){
        try{
            $result=$this->service->update($request,$tool_id);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }

    public function addAssignee(Request $request){
        try{
            $result=$this->service->addAssignee($request);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }

    public function removeAssignee($item_id,$assignee_id,$user_id){
        try{
            $result=$this->service->removeAssignee($item_id,$assignee_id,$user_id);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }

    public function archive($item_id){
        try{
            $result=$this->service->archive($item_id);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }

    public function restore($item_id){
        try{
            $result=$this->service->restore($item_id);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }

    public function delete($item_id,$user_id){
        try{
            $result=$this->service->delete($item_id,$user_id);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }
}
