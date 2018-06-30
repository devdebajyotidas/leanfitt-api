<?php

namespace App\Http\Controllers\API;

use App\Services\DeleteService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TestController extends Controller
{
    protected $service;
    public function __construct(DeleteService $deleteService)
    {
        $this->service=$deleteService;
    }

    public function deleteUser($id){
        try{
            return response()->json($this->service->deleteTest($id));
        }catch (\Exception $e){
            return response()->json($e->getMessage());
        }
    }
}
