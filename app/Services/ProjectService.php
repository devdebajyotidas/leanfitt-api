<?php

namespace App\Services;

use App\Repositories\DeleteRepository;
use App\Repositories\ProjectActivityRepository;
use App\Repositories\ProjectRepository;
use App\Services\Contracts\ProjectServiceInterface;
use App\Validators\ProjectValidator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ProjectService implements ProjectServiceInterface
{

    protected $projectRepo;
    protected $activityRepo;
    protected $deleteRepo;
    public function __construct(ProjectRepository $projectRepository,
                                ProjectActivityRepository $projectActivityRepository,
                                DeleteRepository $deleteRepository)
    {
        $this->projectRepo=$projectRepository;
        $this->activityRepo=$projectActivityRepository;
        $this->deleteRepo=$deleteRepository;
    }

    public function index($request)
    {
        $response=new \stdClass();
        $organization=$request->get('organization');

        $query=$this->projectRepo->allProject();

        if(!empty($organization)){
            $query=$query->where('organization_id',$organization);
        }

        $query=$query->get();

        if(count($query) > 0){
            $data= $query->map(function($item){
                return [
                    'id'=>$item['id'],
                    'name'=>$item['name'],
                    'start_date'=>$item['start_date'],
                    'end_date'=>$item['end_date'],
                    'report_date'=>$item['report_date'],
                    'is_completed'=>$item['is_completed'],
                    'is_archived'=>$item['is_archived'],
//                    'leader'=>isset($item['leaderData']['id']) ? $item['leaderData']['id'] : null,
//                    'leader_name'=>isset($item['leaderData']['id']) ? $item['leaderData']['first_name'].' '.$item['leaderData']['last_name'] : null ,
//                    'leader_avatar'=>isset($item['leaderData']['id']) ? $item['leaderData']['avatar']: null ,
//                    'sensie'=>isset($item['sensie']['id']) ? $item['sensie']['id'] : null,
//                    'sensie_name'=>isset($item['sensie']['id']) ? $item['sensie']['first_name'].' '.$item['sensie']['last_name'] : null,
//                    'sensie_avatar'=>isset($item['sensie']['id']) ? $item['sensie']['avatar'] : null,
                    'item_count'=>count($item['actionItem']),
                    'member_count'=>$item['actionItem']->sum(function($ac){
                        return count($ac->member);
                    }),
                    'comments_count'=>$item['comments_count'],
                    'attachment_count'=>$item['attachments_count'],
                    'created_at'=>Carbon::parse($item['created_at'])->format('Y-m-d H:i:s')
                ];
            });

            $response->success=true;
            $response->data=$data;
            $response->message="Projects Found";
        }
        else{
            $response->success=false;
            $response->data=null;
            $response->message="No Projects available";
        }

        return $response;
    }


    public function show($project_id)
    {
        $response=new \stdClass();
        if(empty($project_id)){
           $response->success=false;
           $response->data=null;
           $response->message="Please select a project";
           return $response;
        }

        $query=$this->projectRepo->getProject($project_id);
        if(count($query) > 0){
            $data['id']=$query['id'];
            $data['name']=$query['name'];
            $data['start_date']=$query['start_date'];
            $data['end_date']=$query['end_date'];
            $data['report_date']=$query['report_date'];
            $data['is_completed']=$query['is_completed'];
            $data['is_archived']=$query['is_archived'];
            $data['leader']=isset($query['leaderData']['id']) ? $query['leaderData']['id'] : null;
            $data['leader_name']=isset($query['leaderData']['id']) ? $query['leaderData']['first_name'].' '.$query['leaderData']['last_name'] : null ;
            $data['leader_avatar']=isset($query['leaderData']['id']) ? $query['leaderData']['avatar'] : null ;
            $data['sensie']=isset($query['sensie']['id']) ? $query['sensie']['id'] : null;
            $data['sensie_name']=isset($query['sensie']['id']) ? $query['sensie']['first_name'].' '.$query['sensie']['last_name'] : null;
            $data['sensie_avatar']=isset($query['sensie']['id']) ? $query['sensie']['avatar'] : null;
            $data['action_items']=count($query['actionItem']) > 0 ? $query['actionItem']->map(function($item){
                return collect($item)->except('member');
            }) : null ;
            $data['members']=count($query['actionItem']) > 0 ? $query['actionItem']->map(function($ac){
                if(isset($ac['member'][0]['user'])){
                    return [
                        'id'=>$ac['member'][0]['user']['id'],
                        'first_name'=>$ac['member'][0]['user']['first_name'],
                        'last_name'=>$ac['member'][0]['user']['last_name'],
                        'avatar'=>$ac['member'][0]['user']['avatar'],
                    ];
                }
                else{
                    return null;
                }
            }) : null ;
            $data['comments']=isset($query['comments']) ? $query['comments']->map(function($comment){
                return [
                    'id'=>$comment['id'],
                    'commenter_id'=>isset($comment['user']['id']) ? $comment['user']['id'] : null,
                    'commenter_name'=>isset($comment['user']['id']) ? $comment['user']['first_name'].' '.$comment['user']['last_name'] : null,
                    'commenter_avatar'=>isset($comment['user']['id']) ? $comment['user']['avatar'] : null,
                    'comment'=>$comment['comment'],
                    'created_at'=>Carbon::parse($comment['created_at'])->format('Y-m-d H:i:s')
                ];
            }) :null;
            $data['attachments']=isset($query['attachments']) ? $query['attachments']->map(function($atta){
                return collect($atta)->except('path');
            }) :null;
            $data['activities']=isset($query['activity']) ? $query['activity']->map(function ($activity){
                  return ['id'=>$activity['id'],
                      'user_id'=>isset($activity['user']['id']) ? $activity['user']['id'] : null,
                      'user_name'=>isset($activity['user']['id']) ? $activity['user']['first_name'].' '.$activity['user']['last_name'] : null,
                      'user_avatar'=>isset($activity['user']['id']) ? $activity['user']['avatar'] : null,
                      'log'=>$activity['log'],
                      'created_at'=>Carbon::parse($activity['created_at'])->format('Y-m-d H:i:s')
                  ];
            }) :null;


            $response->success=true;
            $response->data=$data;
            $response->message="Project found";
        }
        else{
            $response->success=false;
            $response->data=null;
            $response->message="Project not found";
        }

        return $response;
    }

    public function create($request)
    {
        $response=new \stdClass();
        $validator=new ProjectValidator($request->all(),'create');
        if($validator->fails()){
            $response->success=false;
            $response->message=$validator->messages()->first();
            return $response;
        }

        $query=$this->projectRepo->create($request->all());
        if($query){
            $this->activityRepo->create(['added_by'=>$query->created_by,'project_id'=>$query->id,'log'=>'Project created']);
            $response->success=true;
            $response->message="Project has been added";
        }
        else{
            $response->success=false;
            $response->message="Something went wrong, try again later";
        }

        return $response;
    }

    public function update($request, $project_id)
    {
        $response=new \stdClass();
        if(empty($project_id)){
            $response->success=false;
            $response->message="Please select a project";
            return $response;
        }

        if(empty($request->user_id)){
            $response->success=false;
            $response->message="user_id is required";
            return $response;
        }

        $query=$this->projectRepo->update($project_id,$request->all());
        if($query){
            $this->activityRepo->create(['added_by'=>$request->user_id,'project_id'=>$project_id,'log'=>'Project updated']);
            $response->success=true;
            $response->message="Project has been updated";
        }
        else{
            $response->success=false;
            $response->message="Something went wrong, try again later";
        }

        return $response;
    }

    public function archive($project_id,$user_id)
    {
        $response=new \stdClass();
        if(empty($project_id)){
            $response->success=false;
            $response->message="Please select a project";
            return $response;
        }
        if(empty($user_id)){
            $response->success=false;
            $response->message="user_id is required";
            return $response;
        }

        $query=$this->projectRepo->archive($project_id);
        if($query){
            $this->activityRepo->create(['added_by'=>$user_id,'project_id'=>$project_id,'log'=>'Project archived']);
            $response->success=true;
            $response->message="Project has been archived";
        }
        else{
            $response->success=false;
            $response->message="Something went wrong, try again later";
        }

        return $response;
    }

    public function restore($project_id,$user_id)
    {
        $response=new \stdClass();
        if(empty($project_id)){
            $response->success=false;
            $response->message="Please select a project";
            return $response;
        }
        if(empty($user_id)){
            $response->success=false;
            $response->message="user_id is required";
            return $response;
        }

        $query=$this->projectRepo->restore($project_id);
        if($query){
            $this->activityRepo->create(['added_by'=>$user_id,'project_id'=>$project_id,'log'=>'Project restored']);
            $response->success=true;
            $response->message="Project has been restored";
        }
        else{
            $response->success=false;
            $response->message="Something went wrong, try again later";
        }

        return $response;
    }

    public function complete($project_id,$user_id)
    {
        $response=new \stdClass();
        if(empty($project_id)){
            $response->success=false;
            $response->message="Please select a project";
            return $response;
        }
        if(empty($user_id)){
            $response->success=false;
            $response->message="user_id is required";
            return $response;
        }

        $project=$this->projectRepo->find($project_id);
        if($project){
            if($project->is_archived==1){
                $response->success=false;
                $response->message="Can't complete a project which is archived";
                return $response;
            }

            $update=$this->projectRepo->fillUpdate($project,['is_completed'=>1]);
            if($update){
                $this->activityRepo->create(['added_by'=>$user_id,'project_id'=>$project_id,'log'=>'Project completed']);
                $response->success=true;
                $response->message="Project has been marked as completed";
            }
            else{
                $response->success=false;
                $response->message="Something went wrong, try again later";
            }

        }
        else{
            $response->success=false;
            $response->message="Project not found";
        }

        return $response;
    }

    public function delete($project_id,$user_id)
    {
        $response=new \stdClass();
        if(empty($project_id)){
            $response->success=false;
            $response->message="project_id is required";
            return $response;
        }
        if(empty($user_id)){
            $response->success=false;
            $response->message="user_id is required";
            return $response;
        }

        DB::beginTransaction();
        $project=$this->projectRepo->find($project_id);
        if(count($project) > 0){
           if($project->created_by==$user_id || $this->projectRepo->isSuperAdmin($user_id) || $this->projectRepo->isAdmin($user_id)){
               $deleteActionitem=$this->deleteRepo->deleteActionItems('project',$project->id);
               if($deleteActionitem){
                   $self_delete=$this->projectRepo->forceDeleteRecord($project);
                   if($self_delete){
                       DB::commit();
                       $response->success=true;
                       $response->message="Project has been deleted";
                   }
                   else{
                       DB::rollBack();
                       $response->success=false;
                       $response->message="Something went wrong, try again later";
                   }
               }
               else{
                   DB::rollBack();
                   $response->success=false;
                   $response->message="Something went wrong, try again later";
               }
           }
           else{
               DB::rollBack();
               $response->success=false;
               $response->message="You don't have enough permission to delete this project";
           }
        }
        else{
            $response->success=false;
            $response->message="Project not found";
        }

        return $response;
    }
}