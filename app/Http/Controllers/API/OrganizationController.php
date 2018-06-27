<?php

namespace App\Http\Controllers\API;

use App\Services\OrganizationService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrganizationController extends Controller
{
    protected $service;
    public function __construct(OrganizationService $organizationService)
    {
        $this->service=$organizationService;
    }

    public function index(){
        try{
            $result=$this->service->all();
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }

    public function update(Request $request,$organization_id){
        try{
            $result=$this->service->updateOrganization( $request,$organization_id);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }


    public function show($organization_id){
        try{
            $result=$this->service->details($organization_id);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }

    public function list(){
        try{
            $result=$this->service->list();
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }

    public function changeAdmin($organization_id,$employee_id){
        try{
            $result=$this->service->changeAdmin($employee_id,$organization_id);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }

    public function delete($organization_id,$user_id){
        try{
            $result=$this->service->removeOrganization($organization_id,$user_id);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }

}
