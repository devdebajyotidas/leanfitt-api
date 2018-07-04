<?php

namespace App\Services\Contracts;


interface ReportServiceInterface
{
    public function index($request);

    public function names();

    public function show($report_id);

    public function create($request);

    public function delete($report_id,$user_id);

    public function showGridData($report_id);

    public function createGridData($request);

    public function deleteGridData($grid_id);

    public function showChartData($report_id);

    public function createChartData($request);

    public function deleteChartData($chart_id);

    public function changeChartAxis($request,$report_id);

    public function showDefaultData($requets,$report_id,$level);

    public function showDefaultElementData($request,$default_id,$report_id);

    public function createDefaultData($request);

    public function createDefaultElementData($request);

    public function deleteDefaultData($default_id);

    public function deleteDefaultElementData($element_id);

    public function showDefaultAssignments($report_id,$level);

    public function showElementAssignments($report_id,$level);

    public function createDefaultAssignments($request);

    public function createElementAssignments($request);

    public function deleteDefaultAssignments($default_id);

    public function deleteElementAssignments($assignment_id);

    public function showFive($report_id);

    public function createFive($request);

    public function deleteFive($problem_id);

//    public function showFiveWhy($report_id);

    public function createFiveWhy($request);

    public function deleteFiveWhy($reason_id);
}