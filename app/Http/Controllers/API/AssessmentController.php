<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use App\Services\AssessmentService;
use Illuminate\Http\Request;

class AssessmentController extends Controller
{
    protected $service;
    public function __construct(AssessmentService $assessmentService)
    {
        $this->service=$assessmentService;
    }

    public function index($user_id){
        try{
            $result=$this->service->index($user_id);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }

    public function list(Request $request){
        try{
            $result=$this->service->list($request);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }


    public function show($tool_id,$user_id){
        try{
            $result=$this->service->show($tool_id,$user_id);
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
}