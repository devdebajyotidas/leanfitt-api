<?php

namespace App\Http\Controllers\API;


use App\Services\AttachmentService;

class AttachmentController
{
    protected $service;
    public function __construct(AttachmentService $attachmentService)
    {
        $this->service=$attachmentService;
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

    public function delete($attachment_id,$user_id){
        try{
            $result=$this->service->delete($attachment_id,$user_id);
            return response()->json($result);
        }catch(\Exception $e){
            $response['success']=false;
            $response['message']=$e->getMessage();
            return response()->json($response);
        }
    }
}