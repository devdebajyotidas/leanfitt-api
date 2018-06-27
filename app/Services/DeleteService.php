<?php

namespace App\Services;


use App\Models\ActionItemAssignee;
use App\Models\Attachment;
use App\Models\Award;
use App\Models\Comment;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Invitation;
use App\Models\KpiDataPoint;
use App\Models\ProjectActivity;
use App\Models\QuizResult;
use App\Models\User;

class DeleteService
{
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

    public function deleteUser($id){
        /*assignee,comment,password,admin,device,employee*/
    }

    public function deleteEmployee($id,$type){
        $count=0;
        if($type=='id'){
            $employee=Employee::find($id);
            if(count($employee) > 0){
                $quiz=$this->deleteQuiz($employee->id);
                $award=$this->deleteAward($employee->id);
                $user=$this->deleteUser($employee->user_id);
                if($quiz && $award && $user && $employee->forceDelete()){
                    $count++;
                }
            }
            else{
                $count++;
            }
        }
        elseif($type=='department'){
            $employee=Employee::where('department_id',$id)->get();
            if(count($employee) > 0){
                foreach ($employee as $emp){
                    $quiz=$this->deleteQuiz($emp->id);
                    $award=$this->deleteAward($emp->id);
                    $user=$this->deleteUser($emp->user_id);
                    /*delete subscrition*/
                    if($quiz && $award && $user && $emp->forceDelete()){
                        $count++;
                    }
                }
            }
            else{
                $count++;
            }
        }
        elseif($type=='user') {
            $employee = Employee::where('user_id', $id)->first();
            if (count($employee) > 0) {
                $quiz = $this->deleteQuiz($employee->id);
                $award = $this->deleteAward($employee->id);
                $user = $this->deleteUser($employee->user_id);
                if ($quiz && $award && $user && $employee->forceDelete()) {
                    $count++;
                }
            }
            else{
                $count++;
            }
        }

        if($count > 0){
            return true;
        }
        else{
            return false;
        }

    }

    public function deleteAdmin($id){
        return Attachment::find($id)->forceDelete();
    }

    public function deleteDepartment($id){

    }

    public function deleteKpiChart(){

    }

    public function deleteOrganizationAdmin(){

    }

    public function deleteActionItem(){

    }

    public function deleteReport(){

    }

    public function deleteProject(){

    }

    public function deleteALeanTool(){

    }

    public function deleteOrganization(){

    }
}