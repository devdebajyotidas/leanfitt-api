<?php

namespace App\Http\Controllers\API;

use App\Services\AuthService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    protected $service;
    public function __construct(AuthService $authService)
    {
        $this->service=$authService;
    }

    public function login(Request $request){
        try{
            $result=$this->service->login($request);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }

    public function recovery(Request $request){
        try{
            $result=$this->service->recovery($request);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }

    public function checkResetCode($code){
        try{
            $result=$this->service->checkResetCode($code);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }

    public function switchAccount(Request $request){
        try{
            $result=$this->service->switchAccount($request);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }

    public function updatePassword(Request $request){
        try{
            $result=$this->service->updatePassword($request);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }
}
