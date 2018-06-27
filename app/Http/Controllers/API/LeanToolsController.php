<?php

namespace App\Http\Controllers\API;

use App\Services\LeanToolService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LeanToolsController extends Controller
{
    protected $service;
    public function __construct(LeanToolService $leanToolService)
    {
        $this->service=$leanToolService;
    }

    public function index(){
        try{
            $result=$this->service->index();
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

    public function show($tool_id){
        try{
            $result=$this->service->show($tool_id);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }

    public function delete($tool_id,$user_id){
        try{
            $result=$this->service->delete($tool_id,$user_id);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }
}
