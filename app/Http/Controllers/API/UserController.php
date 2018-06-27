<?php

namespace App\Http\Controllers\API;

use App\Services\UserService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    protected $service;
    public function __construct(UserService $userService)
    {
        $this->service=$userService;
    }

    public function signup(Request $request){
        try{
            $result=$this->service->signup($request);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }

    public function accounts($user_id){
        try{
            $result=$this->service->accounts($user_id);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }

    public function profile($user_id){
        try{
            $result=$this->service->profile($user_id);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }

    public function update(Request $request,$user_id){
        try{
            $result=$this->service->update($request,$user_id);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }

    public function deactivate($user_id){
        try{
            $result=$this->service->deactivate($user_id);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }

    public function joinEmployee(Request $request){
        try{
            $result=$this->service->joinEmployee($request);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }
}
