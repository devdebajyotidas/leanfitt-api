<?php

namespace App\Http\Controllers\API;


use App\Services\CommentService;
use Illuminate\Support\Facades\Request;

class CommentController
{
    protected $service;
    public function __construct(CommentService $commentService)
    {
        $this->service=$commentService;
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

    public function update(Request $request,$comment_id){
        try{
            $result=$this->service->update($request,$comment_id);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }

    public function delete($comment_id,$user_id){
        try{
            $result=$this->service->delete($comment_id,$user_id);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }

}