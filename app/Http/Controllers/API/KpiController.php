<?php

namespace App\Http\Controllers\API;

use App\Services\KpiService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KpiController extends Controller
{
    protected $service;
    public function __construct(KpiService $kpiService)
    {
        $this->service=$kpiService;
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

    public function show($kpi_id){
        try{
            $result=$this->service->show($kpi_id);
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

    public function update(Request $request,$kpi_id){
        try{
            $result=$this->service->update($request,$kpi_id);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }

    public function delete($kpi_id,$user_id){
        try{
            $result=$this->service->delete($kpi_id,$user_id);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }

    public function addDataPoint(Request $request){
        try{
            $result=$this->service->addDataPoint($request);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }

    public function filterDataPoint(Request $request){
        try{
            $result=$this->service->filterDataPoint($request);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }

    public function deleteDataPoint($point_id,$user_id){
        try{
            $result=$this->service->deleteDatapoint($point_id,$user_id);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }

}
