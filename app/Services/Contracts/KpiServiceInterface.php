<?php

namespace App\Services\Contracts;


interface KpiServiceInterface
{
    public function index($request);

    public function show($kpi_id);

    public function create($request);

    public function update($request,$kpi_id);

    public function delete($kpi_id,$user_id);

    public function addDataPoint($request);

    public function filterDataPoint($request);

    public function deleteDatapoint($point_id,$user_id);
}