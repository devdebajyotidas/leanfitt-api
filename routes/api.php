<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'API'], function () {

    /*Auth Services*/
    Route::post('account/login', 'AuthController@login'); /*check subscription*/
    Route::post('account/recovery', 'AuthController@recovery');
    Route::get('account/recovery/check/{code}', 'AuthController@checkResetCode');
    Route::post('account/switch', 'AuthController@switchAccount'); /*update session (role)*/
    Route::post('account/password/update', 'AuthController@updatePassword');

    /*User Services*/
    Route::post('account/signup', 'UserController@signup');
    Route::get('user/accounts/{user_id}', 'UserController@accounts'); //associated accounts for switch
    Route::get('user/profile/{user_id}', 'UserController@profile');
    Route::put('user/profile/{user_id}', 'UserController@update');
    Route::delete('account/delete/{user_id}', 'UserController@deactivate');
    Route::post('account/join/employee', 'UserController@joinEmployee'); /*if admin and want to join as employee*/

    /*Organization*/
    Route::get('organizations', 'OrganizationController@index');
    Route::get('organizations/{organization_id}', 'OrganizationController@show');
    Route::put('organizations/{organization_id}', 'OrganizationController@update');
    Route::get('organizations/list/all', 'OrganizationController@list'); /*for multi purpose dropdown*/
    Route::delete('organizations/{organization_id}/{user_id}', 'OrganizationController@delete');
    Route::post('organizations/admin/change', 'OrganizationController@changeAdmin');

    /*Employee*/
    Route::get('employees', 'EmployeeController@index'); /*organization,department*/
    Route::get('employees/show/{employee_id}', 'EmployeeController@show');
    Route::post('employees/department/change', 'EmployeeController@changeDepartment');
    Route::get('employees/list', 'EmployeeController@list'); /*for multi purpose dropdown use department,orgnization*/
    Route::post('employees/invite', 'EmployeeController@invite');
    Route::get('employees/invite/resend/{invitaion_id}', 'EmployeeController@resendInvitation');
    Route::post('employees/join', 'EmployeeController@join'); /*join invited*/
    Route::get('employees/archive/{employee_id}', 'EmployeeController@archive');
    Route::get('employees/restore/{employee_id}', 'EmployeeController@restore');
    Route::delete('employees/{employee_id}', 'EmployeeController@delete');

    Route::post('employees/subscribe/{employee_id}', 'EmployeeController@subscribe');

    /*Departments*/
    Route::get('departments', 'DepartmentController@index'); /*filter organization*/
    Route::get('departments/list', 'DepartmentController@list'); /*for multi purpose dropdown*/
    Route::get('departments/show/{department_id}', 'DepartmentController@show');
    Route::post('departments', 'DepartmentController@create');
    Route::put('departments/{department_id}', 'DepartmentController@update');
    Route::get('departments/archive/{department_id}', 'DepartmentController@archive');
    Route::get('departments/restore/{department_id}', 'DepartmentController@restore');
    Route::delete('departments/{department_id}/{user_id}', 'DepartmentController@delete');

    /*Lean Tools*/
    Route::get('leantools', 'LeanToolsController@index');
    Route::post('leantools', 'LeanToolsController@create');
    Route::put('leantools/{tool_id}', 'LeanToolsController@update');
    Route::delete('leantools/{tool_id}/{user_id}', 'LeanToolsController@delete');
    Route::get('leantools/{tool_id}', 'LeanToolsController@show');

    /*Quiz*/
    Route::get('quiz/{user_id}', 'QuizController@index');
    Route::get('quiz/taken/list', 'QuizController@taken'); /*use filter for department and organization eg. url?department=1*/
    Route::get('quiz/take/{tool_id}/{user_id}', 'QuizController@show'); /*display with result, if result then display result page*/
    Route::post('quiz/post/result', 'QuizController@create');

    /*Assessment*/
    Route::get('assessment/{user_id}', 'AssessmentController@index');
    Route::get('assessment/show/{tool_id}/{user_id}', 'AssessmentController@show');
    Route::get('assessment/taken/list', 'AssessmentController@list'); /*department and organization,user*/
    Route::post('assessment/result', 'AssessmentController@create');

    /*Action Items*/
    Route::get('items/{type}', 'ActionItemController@index'); /*use filter for department and organization eg. url?department=1&type=report*/
    Route::get('items/find/{item_id}', 'ActionItemController@show'); /*comment,images,assignee*/
    Route::post('items', 'ActionItemController@create');
    Route::put('items/{item_id}', 'ActionItemController@update');/*update any data name,due date,position,board*/

    Route::post('items/member', 'ActionItemController@addAssignee'); /*item_id*/
    Route::delete('items/member/{item_id}/{assignee_id}/{user_id}', 'ActionItemController@removeAssignee');

    Route::get('items/assignments/all', 'ActionItemController@getAssignment');
    Route::post('items/assignments', 'ActionItemController@addAssignment');
    Route::put('items/assignments/{assignment_id}', 'ActionItemController@updateAssignment');
    Route::delete('items/assignments/{assignment_id}', 'ActionItemController@removeAssignment');

    Route::get('items/archive/{item_id}', 'ActionItemController@archive');
    Route::get('items/restore/{item_id}', 'ActionItemController@restore');
    Route::delete('items/delete/{item_id}/{user_id}', 'ActionItemController@delete');

    /*Comment*/
    Route::post('comment', 'CommentController@create'); /*item_id*/
    Route::put('comment/{comment_id}', 'CommentController@update');
    Route::delete('comment/{comment_id}/{user_id}', 'CommentController@delete');

    /*Attachment*/
    Route::post('attachment', 'AttachmentController@create'); /*item_id*/
    Route::delete('attachment/{attachment_id}/{user_id}', 'AttachmentController@delete');

    /*Project*/
    Route::get('projects', 'ProjectController@index'); /*filter by organization*/
    Route::get('projects/{project_id}', 'ProjectController@show');
    Route::post('projects', 'ProjectController@create');
    Route::put('projects/{project_id}', 'ProjectController@update');

    Route::get('projects/archive/{project_id}/{user_id}', 'ProjectController@archive');
    Route::get('projects/restore/{project_id}/{user_id}', 'ProjectController@restore');
    Route::get('projects/complete/{project_id}/{user_id}', 'ProjectController@complete');
    Route::delete('projects/{project_id}/{user_id}', 'ProjectController@delete');

    /*Kpi*/
    Route::get('kpi', 'KpiController@index'); /*filter by organization,project*/
    Route::get('kpi/{kpi_id}', 'KpiController@show');
    Route::post('kpi', 'KpiController@create');
    Route::put('kpi/{kpi_id}', 'KpiController@update');
    Route::delete('kpi/{kpi_id}/{user_id}', 'KpiController@delete');

    Route::post('kpi/data', 'KpiController@addDataPoint');
    Route::post('kpi/data/filter', 'KpiController@filterDataPoint'); /*kpi_id,start_date,end_date*/
    Route::delete('kpi/data/{point_id}/{user_id}', 'KpiController@deleteDataPoint');

    /*Award*/
    Route::get('awards', 'AwardController@index'); /*department,organization,user_id*/

    /*Report*/
    Route::get('reports', 'ReportController@index'); /*all reports filterable organization projects*/
    Route::get('reports/names', 'ReportController@names'); /*all the report name*/
    Route::get('reports/show/{report_id}', 'ReportController@show'); /*get the report*/
    Route::post('reports', 'ReportController@create'); /*get the report*/
    Route::delete('reports/delete/{report_id}/{user_id}', 'ReportController@delete'); /*get the report*/

    Route::get('reports/grid/{report_id}', 'ReportController@showGridData'); /*display all the grid data*/
    Route::post('reports/grid', 'ReportController@createGridData'); /*new grid data*/
    Route::delete('reports/grid/{grid_id}', 'ReportController@deleteGridData'); /*Delete a grid data*/

    Route::get('reports/chart/{report_id}', 'ReportController@showChartData');
    Route::post('reports/chart', 'ReportController@createChartData');
    Route::delete('reports/chart/{chart_id}', 'ReportController@deleteChartData');
    Route::post('reports/chart/axis/{report_id}', 'ReportController@changeChartAxis');

    Route::get('reports/default/{report_id}/{level}', 'ReportController@showDefaultData'); /*filter using type*/
    Route::get('reports/element/{default_id}/{report_id}', 'ReportController@showDefaultElementData'); /*filter using sort*/
    Route::post('reports/default', 'ReportController@createDefaultData');
    Route::post('reports/element', 'ReportController@createDefaultElementData');
    Route::delete('reports/default/{default_id}', 'ReportController@deleteDefaultData');
    Route::delete('reports/element/{element_id}', 'ReportController@deleteDefaultElementData');
    Route::get('reports/default/assignments/{report_id}/{level}', 'ReportController@showDefaultAssignments');
    Route::get('reports/element/assignments/{default_id}/{level}', 'ReportController@showElementAssignments');
    Route::post('reports/default/assignments', 'ReportController@createDefaultAssignments');
    Route::post('reports/element/assignments', 'ReportController@createElementAssignments');
    Route::delete('reports/default/assignments/{assignment_id}', 'ReportController@deleteDefaultAssignments');
    Route::delete('reports/element/assignments/{assignment_id}', 'ReportController@deleteElementAssignments');

    Route::get('reports/problem/{report_id}', 'ReportController@showFive');
    Route::post('reports/problem', 'ReportController@createFive');
//    Route::get('reports/five/why/{report_id}', 'ReportController@showFiveWhy');
    Route::post('reports/reason', 'ReportController@createFiveWhy');
    Route::delete('reports/problem/{problem_id}', 'ReportController@deleteFive');
    Route::delete('reports/reason/{reason_id}', 'ReportController@deleteFiveWhy');
});
