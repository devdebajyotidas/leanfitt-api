<?php

namespace App\Http\Controllers\API;

use App\Services\ReportService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    protected $service;
    public function __construct(ReportService $reportService)
    {
        $this->service=$reportService;
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

    public function names(){
        try{
            $result=$this->service->names();
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }

    public function show($report_id){
        try{
            $result=$this->service->show($report_id);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }

    public function delete($report_id,$user_id){
        try{
            $result=$this->service->delete($report_id,$user_id);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }

    public function showGridData($report_id){
        try{
            $result=$this->service->showGridData($report_id);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }

    public function createGridData(Request $request){
        try{
            $result=$this->service->createGridData($request);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }

    public function deleteGridData($grid_id){
        try{
            $result=$this->service->deleteGridData($grid_id);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }

    public function showChartData($report_id){
        try{
            $result=$this->service->showChartData($report_id);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }

    public function createChartData(Request $request){
        try{
            $result=$this->service->createChartData($request);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }

    public function deleteChartData($chart_id){
        try{
            $result=$this->service->deleteChartData($chart_id);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }

    public function changeChartAxis(Request $request,$report_id){
        try{
            $result=$this->service->changeChartAxis($request,$report_id);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }

    public function showDefaultData(Request $request,$report_id,$level){
        try{
            $result=$this->service->showDefaultData($request,$report_id,$level);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }

    public function showDefaultElementData(Request $request,$default_id,$report_id){
        try{
            $result=$this->service->showDefaultElementData($request,$default_id,$report_id);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }

    public function createDefaultData(Request $request){
        try{
            $result=$this->service->createDefaultData($request);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }

    public function createDefaultElementData(Request $request){
        try{
            $result=$this->service->createDefaultElementData($request);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }

    public function deleteDefaultData($default_id){
        try{
            $result=$this->service->deleteDefaultData($default_id);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }

    public function deleteDefautlElementData($element_id){
        try{
            $result=$this->service->deleteDefaultElementData($element_id);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }

    public function showDefaultAssignments($report_id,$level){
        try{
            $result=$this->service->showDefaultAssignments($report_id,$level);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }

    public function showElementAssignments($report_id,$level){
        try{
            $result=$this->service->showElementAssignments($report_id,$level);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }

    public function createDefaultAssignments(Request $request){
        try{
            $result=$this->service->createDefaultAssignments($request);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }

    public function createElementAssignments(Request $request){
        try{
            $result=$this->service->createElementAssignments($request);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }

    public function deleteDefaultAssignments($default_id){
        try{
            $result=$this->service->deleteDefaultAssignments($default_id);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }

    public function deleteElementAssignments($assignment_id){
        try{
            $result=$this->service->deleteElementAssignments($assignment_id);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }

    public function showFive($report_id){
        try{
            $result=$this->service->showFive($report_id);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }

    public function createFive(Request $request){
        try{
            $result=$this->service->createFive($request);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }

    public function showFiveWhy($report_id){
        try{
            $result=$this->service->showFiveWhy($report_id);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }

    public function createFiveWhy(Request $request){
        try{
            $result=$this->service->createFiveWhy($request);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }

    public function deleteFive($problem_id){
        try{
            $result=$this->service->deleteFive($problem_id);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }

    public function deleteFiveWhy($reason_id){
        try{
            $result=$this->service->deleteFiveWhy($reason_id);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }
}
