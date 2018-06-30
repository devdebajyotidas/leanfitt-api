<?php

namespace App\Services;


use App\Listeners\ProcessStopSubscription;
use App\Models\ActionItemAssignee;
use App\Models\Admin;
use App\Models\Attachment;
use App\Models\Award;
use App\Models\Comment;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Invitation;
use App\Models\KpiDataPoint;
use App\Models\OrganizationAdmin;
use App\Models\ProjectActivity;
use App\Models\QuizResult;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DeleteService
{
    public function deleteTest($id){
        return User::find($id)->forceDelete();
    }

    public function performDelete($id,$user_id,$type){
        return true;
    }

    public function checkPermission($id,$user_id,$type){

    }

    public function deleteAward($employee_id){
         return Award::find($employee_id)->forceDelete();
    }

    public function deleteComment($id){
        return Comment::find($id)->forceDelete();
    }

    public function deleteQuiz($employee_id){
        return QuizResult::find($employee_id)->forceDelete();
    }

    public function deleteInvitation($id){
        return Invitation::find($id)->forceDelete();
    }

    public function deleteKpiData($id){
        return KpiDataPoint::find($id)->forceDelete();
    }

    public function deleteProjectActivity($id){
        return ProjectActivity::find($id)->forceDelete();
    }

    public function deleteAttachment($id){
        return Attachment::find($id)->forceDelete();
    }

    public function deleteLeanTool(){
        /*this is not deletable use is_deleted or softDeletes*/
        /*Only self*/
    }

    public function deleteActionItemAssignee($id,$type){
        $count=0;
        if($type=='action_item'){
            $items=ActionItemAssignee::where('action_item_id',$id)->get();
        }
        else{
            $items=ActionItemAssignee::where('user_id',$id)->get();
        }
        if(count($items) > 0){
            foreach ($items as $item){
                if($item->forceDelete()){
                    $count++;
                }
            }
        }

       if($count > 0){
            return true;
       }
       else{
            return false;
       }
    }


    /*Related*/

    public function deleteUser($id){
        DB::beginTransaction();
        $count_ais=0;

        /*action_item_assignee*/
        $ais=ActionItemAssignee::where('user_id',$id)->get();
        if(count($ais) > 0){
            foreach ($ais as $a){
                $delete_ais=$this->deleteActionItemAssignee($a->id);
                if($delete_ais){
                    $count_ais++;
                }
            }

        }
        else{
            $count_ais++;
        }

        /*employee*/
        $employee=Employee::where('user_id',$id)->first();
        $delete_emp=count($employee) > 0 ? $this->deleteEmployee($employee->id) : true;
        /*admin*/
        $admin=Admin::where('user_id',$id)->first();
        $delete_admin=count($admin) > 0? $this->deleteAdmin($admin->id) : true;
        /*reset*/

        /*device*/

        $delete_self=User::find($id)->forceDelete();

        if($count_ais > 0 && $delete_emp && $delete_admin && $delete_self){
            DB::commit();
            return true;
        }
        else{
            DB::rollBack();
            return false;
        }
    }

    public function deleteEmployee($id){
        DB::beginTransaction();
        $award_count=$quiz_count=0;
        $employee=Employee::find($id);

        /*subscription*/
        $subscription=Subscription::where('employee_id',$id)->first();
        event(new ProcessStopSubscription($subscription));
        $delete_subscription=count($subscription) > 0 ? $this->deleteSubscription($subscription->id) : true;

        /*user*/
        $delete_user=count($employee) > 0 ? $this->deleteUser($employee->user_id) : true;
        /*awards*/
        $awards=Award::where('employee_id',$id)->get();
        if(count($awards) > 0){
            foreach ($awards as $aw){
              $award_delete=$this->deleteAward($aw->id);
              if($award_delete){
                  $award_count++;
              }
            }
        }
        else{
            $award_count++;
        }
        /*quizresult*/
        $quizs=QuizResult::where('employee_id',$id)->get();
        if(count($quizs) > 0){
            foreach ($quizs as $q){
                $quiz_delete=$this->deleteAward($q->id);
                if($quiz_delete){
                    $quiz_count++;
                }
            }
        }
        else{
            $quiz_count++;
        }

        /*self*/
        $self_delete=$employee->forceDelete();

        if($award_count > 0 && $delete_user && $quiz_count > 0 && $delete_subscription && $self_delete){
            DB::commit();
            return true;
        }
        else{
            DB::rollBack();
            return false;
        }
    }

    public function deleteAdmin($id){
        DB::beginTransaction();
        $orgadmin_count=0;
        $admin=Admin::find($id);
        /*Organization Admin*/
        $org_admins=OrganizationAdmin::where('admin_id',$id)->get();
//        if(count($org_admins) > 0){
//            foreach ($org_admins as $oa){
//                $oa_delete=
//            }
//        }
//        else{
//            $orgadmin_count++;
//        }
        /*user*/
        $delete_user=count($employee) > 0 ? $this->deleteUser($admin->user_id) : true;
        /*self*/
    }

    public function deleteDepartment($id){
        /*Employee*/
        /*invitation*/
        /*self*/
    }

    public function deleteKpiChart(){
        /*kpi data points*/
    }

    public function deleteOrganizationAdmin(){
        /*Not Necessary*/
    }

    public function deleteActionItem(){
        /*action item assignee*/
        /*comments*/
        /*attachments*/
        /*self*/
    }

    public function deleteReport(){

    }

    public function deleteProject(){
        /*kpi chart*/
        /*action item*/
        /*comments*/
        /*attachments*/
        /*reports*/
        /*projetc activities*/
        /*self*/
    }

    public function deleteOrganization(){
        /*admins*/
        /*employee*/
        /*all department*/
        /*projects*/
        /*invitations*/
        /*self*/
    }
}