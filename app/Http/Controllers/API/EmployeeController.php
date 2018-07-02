<?php

namespace App\Http\Controllers\API;

use App\Services\EmployeeService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmployeeController extends Controller
{
    protected $service;
    public function __construct(EmployeeService $employeeService)
    {
        $this->service=$employeeService;
    }

    public function index(Request $request){
        try{
            $result=$this->service->index($request);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }

    public function show($employee_id){
        try{
            $result=$this->service->show($employee_id);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }

    public function changeDepartment(Request $request){
        try{
            $result=$this->service->changeDepartment($request);
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

    public function invite(Request $request){
        try{
            $result=$this->service->invite($request);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }

    public function resendInvitation($invitation_id){
        try{
            $result=$this->service->resend($invitation_id);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }

    public function join(Request $request){
        try{
            $result=$this->service->join($request);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }

    public function archive($employee_id){
        try{
            $result=$this->service->archive($employee_id);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }

    public function restore($employee_id){
        try{
            $result=$this->service->restore($employee_id);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }

    public function delete($employee_id){
        try{
            $result=$this->service->delete($employee_id);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }

    public function subscribe($employee_id){
        try{
            $result=$this->service->subscribe($employee_id);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }
}
