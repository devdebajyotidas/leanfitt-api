<?php

namespace App\Http\Controllers\API;

use App\Services\QuizService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QuizController extends Controller
{
    protected $service;
    public function __construct(QuizService $quizService)
    {
        $this->service=$quizService;
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

    public function taken(Request $request){
        try{
            $result=$this->service->taken($request);
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
