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
    Route::get('account/deactivate/{user_id}', 'UserController@deactivate');
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
    Route::delete('employees/{employee_id}/{user_id}', 'EmployeeController@delete');

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
    Route::post('quiz/post/result', 'QuizController@create');;

    /*Action Items*/
    Route::get('items/{type}', 'ActionItemController@index'); /*use filter for department and organization eg. url?department=1&type=report*/
    Route::get('items/find/{item_id}', 'ActionItemController@show'); /*comment,images,assignee*/
    Route::post('items', 'ActionItemController@create');
    Route::put('items/{item_id}', 'ActionItemController@update');/*update any data name,due date,position,board*/

    Route::post('item/member', 'ActionItemController@addAssignee'); /*item_id*/
    Route::delete('item/comment/{item_id}/{assignee_id}/{user_id}', 'ActionItemController@removeAssignee');

    Route::get('item/archive/{item_id}', 'ActionItemController@archive');
    Route::get('item/restore/{item_id}', 'ActionItemController@restore');
    Route::get('item/delete/{item_id}/{user_id}', 'ActionItemController@delete');

    /*Comment*/
    Route::post('comment', 'ActionItemController@create'); /*item_id*/
    Route::put('comment/{comment_id}', 'ActionItemController@update');
    Route::delete('comment/{comment_id}/{user_id}', 'ActionItemController@delete');

    /*Attachment*/
    Route::post('attachment', 'ActionItemController@create'); /*item_id*/
    Route::delete('attachment/{attachment_id}/{user_id}', 'ActionItemController@delete');

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

    /*Report*/

    /*Dashboard*/

    /*Award*/
    Route::get('awards', 'AwardController@index'); /*department,organization,user_id*/

});
