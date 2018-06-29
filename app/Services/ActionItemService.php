<?php

namespace App\Services;


use App\Repositories\ActionItemAssigneeRepository;
use App\Repositories\ActionItemRepository;
use App\Repositories\CommentRepository;
use App\Repositories\Contracts\AttachmentRepository;
use App\Repositories\DeleteService;
use App\Repositories\MediaRepository;
use App\Services\Contracts\ActionItemServiceInterface;
use App\Validators\ActionItemAssigneeValidator;
use App\Validators\ActionItemValidator;
use App\Validators\CommentValidator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ActionItemService implements ActionItemServiceInterface
{
    protected $itemRepo;
    protected $assigneeRepo;
    protected $attachmentRepo;
    protected $mediaRepo;
    protected $commentRepo;
    public function __construct(ActionItemAssigneeRepository $actionItemAssigneeRepository,
                                ActionItemRepository $actionItemRepository,
                                AttachmentRepository $attachmentRepository,
                                CommentRepository $commentRepository,
                                MediaRepository $mediaRepository)
    {
        $this->itemRepo=$actionItemRepository;
        $this->assigneeRepo=$actionItemAssigneeRepository;
        $this->attachmentRepo=$attachmentRepository;
        $this->commentRepo=$commentRepository;
        $this->mediaRepo=$mediaRepository;
    }

    public function index($request,$type)
    {
        $response=new \stdClass();
        if(empty($type)){
            $response->success=false;
            $response->data=null;
            $response->message="Please select a action item type";
            return $response;
        }

        $organization=$request->get('organization');
        $id=$request->get('id');
        $user=$request->get('user');
        $board=$request->get('board');

        if($type=='project'){
            $query=$this->itemRepo->allProjectActions();
        }
        else{
            $query=$this->itemRepo->allReportActions();
        }

        if(!empty($organization)){
            $query=$query->where('organization_id',$organization);
        }
        if(!empty($id)){
            $query=$query->where('itemable_id',$id);
        }
        if(!empty($user)){
            $query=$query->where('user_id',$user)->orWhere('assignor_id',$user);
        }
        if(!empty($board)){
            $query=$query->where('board_id',$board);
        }

        $query= $query->get()->unique();
        $data= $query->map(function($item){
            return collect($item)->except(['itemable_type','itemable_id','created_by','user_id','organization_id']);
        });

        if(count($data) > 0){
            $response->success=true;
            $response->data=$data;
            $response->message="Items found";
        }
        else{
            $response->success=false;
            $response->data=null;
            $response->message="No items found";
        }

        return $response;
    }

    public function show($item_id)
    {
        $response=new \stdClass();
        if(empty($item_id)){
           $response->success=false;
           $response->data=null;
           $response->message="Please select an action item";
           return $response;
        }

        $query=$this->itemRepo->getItem($item_id);

        if(count($query) > 0){
            $data['id']=$query['id'];
            $data['name']=$query['name'];
            $data['board_id']=$query['board_id'];
            $data['board_name']=isset($query['board']['name']) ? $query['board']['name'] : null;
            $data['assignor_id']=isset($query['assignor']['id']) ? $query['assignor']['id'] :null;
            $data['assignor_name']=isset($query['assignor']['id']) ? $query['assignor']['first_name'].' '.$query['assignor']['last_name'] :null;
            $data['assignor_avatar']=isset($query['assignor']['id']) ? $query['assignor']['avatar'] :null;
            $data['members']=count($query['member']) > 0 ? $query['member']->map(function($member){
                if(isset($member['user'])){
                    return ['id'=>$member['user']['id'],'first_name'=>$member['user']['first_name'],'last_name'=>$member['user']['last_name'],'avatar'=>$member['user']['avatar']];
                }
                else{
                    return null;
                }

            }): null;
            $data['comments']=count($query['comments']) > 0 ? $query['comments']->map(function($comment){
                return [
                    'id'=>$comment['id'],
                    'comment'=>$comment['comment'],
                    'commenter_id'=>isset($comment['user']['id']) ? $comment['user']['id'] : null,
                    'commenter_name'=>isset($comment['user']['id']) ? $comment['user']['first_name'] .' '.$comment['user']['last_name'] : null,
                    'commenter_avatar'=>isset($comment['user']['id']) ? $comment['user']['avatar'] : null,
                    'created_at'=>Carbon::parse($comment['created_at'])->format('Y-m-d H:i:s')
                ];
            }) : null;
            $data['attachments']=isset($query['attachments']) ? $query['attachments'] : null;
            $data['created_at']=Carbon::parse($query['created_at'])->format('Y-m-d H:i:s');
            $data['position']=$query['position'];
            $data['due_date']=$query['due_date'];
            $data['description']=$query['description'];

            $response->success=true;
            $response->data=new Collection($data);
            $response->message="Item found";
        }
        else{
            $response->success=false;
            $response->data=null;
            $response->message="Something went wrong, try again later";
        }

        return $response;
    }

    public function create($request)
    {
        $response=new \stdClass();
        $validator=new ActionItemValidator($request->all(),'create');
        if($validator->fails()){
            $response->success=false;
            $response->message=$validator->messages()->first();
            return $response;
        }

        $data=$request->all();
        if($request->type=='project'){
            if(empty($request->get('project_id'))){
                $response->success=false;
                $response->message="project_id is required";
                return $response;
            }

            $data['itemable_type']='App\Models\Project';
            $data['itemable_id']=$request->project_id;
        }
        else{
            if(empty($request->get('report_id'))){
                $response->success=false;
                $response->message="report_id is required";
                return $response;
            }

            $data['itemable_type']='App\Models\Report';
            $data['itemable_id']=$request->report_id;
        }

        DB::beginTransaction();
        $query=$this->itemRepo->create($data);
        if($query){
            DB::commit();
            $response->success=true;
            $response->message="New action item has been added";
        }
        else{
            DB::rollBack();
            $response->success=false;
            $response->message="Something went wrong, try again later";
        }

        return $response;
    }

    public function update($request, $item_id)
    {
        $response=new \stdClass();;
        if(empty($item_id)){
            $response->success=false;
            $response->message="Please select an action item";
            return $response;
        }

        DB::beginTransaction();
        $query=$this->itemRepo->update($item_id,$request->all());
        if($query){
            DB::commit();
            $response->success=true;
            $response->message="Action item has been updated";
        }
        else{
            DB::rollBack();
            $response->success=false;
            $response->message="Something went wrong, try again later";
        }

        return $response;

    }

    public function addAssignee($request)
    {
        $response=new \stdClass();
        $validator=new ActionItemAssigneeValidator($request->all(),'create');
        if($validator->fails()){
            $response->success=false;
            $response->message=$validator->messages()->first();
            return $response;
        }

        DB::beginTransaction();
        $exist=$this->assigneeRepo->where('action_item_id',$request->action_item_id)->where('user_id',$request->user_id)->exists();

        if($exist){
            $response->success=false;
            $response->message="The user is already member of this action item";
            return $response;
        }
        else{
            $query=$this->assigneeRepo->create($request->all());
            if($query){
                DB::commit();
                $response->success=true;
                $response->message="A member has been added";
            }
            else{
                DB::rollBack();
                $response->success=false;
                $response->message="Something went wrong, try again later";
            }
        }


        return $response;
    }

    public function removeAssignee($item_id,$assignee_id,$user_id)
    {
        $response=new \stdClass();
        if(empty($item_id)){
            $response->success=false;
            $response->message="Invalid comment selection";
            return $response;
        }

        if(empty($user_id)){
            $response->success=false;
            $response->message="current user_id is required";
            return $response;
        }

        if(empty($assignee_id)){
            $response->success=false;
            $response->message="assignee_id is required";
            return $response;
        }

        DB::beginTransaction();
        $assignee=$this->assigneeRepo->where('user_id',$assignee_id)->where('action_item_id',$item_id)->first();
        if($assignee){
            if($assignee->user_id==$user_id || $this->assigneeRepo->isAdmin($user_id) || $this->assigneeRepo->isSuperAdmin($user_id)){
                $query=$this->assigneeRepo->forceDeleteRecord($assignee);
                if($query){
                    DB::commit();
                    $response->success=true;
                    $response->message="Assignee has been removed";
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
                $response->message="You don't have enough permission to delete the assignee";
            }
        }
        else{
            DB::rollBack();
            $response->success=false;
            $response->message="Assignee not found";
        }

        return $response;
    }


    public function archive($item_id)
    {
        $response=new \stdClass();
        if(empty($item_id)){
            $response->success=false;
            $response->message="Invalid action item selection";
            return $response;
        }

        DB::beginTransaction();
        $query=$this->itemRepo->restore($item_id);
        if($query){
            DB::commit();
            $response->success=true;
            $response->message='Action item has been archived';
        }
        else{
            DB::rollBack();
            $response->success=false;
            $response->message="Something went wrong, try again later";
        }

        return $response;
    }

    public function restore($item_id)
    {
        $response=new \stdClass();
        if(empty($item_id)){
            $response->success=false;
            $response->message="Invalid action item selection";
            return $response;
        }

        DB::beginTransaction();
        $query=$this->itemRepo->restore($item_id);
        if($query){
            DB::commit();
            $response->success=true;
            $response->message='Action item has been restored';
        }
        else{
            DB::rollBack();
            $response->success=false;
            $response->message="Something went wrong, try again later";
        }

        return $response;
    }

    public function delete($item_id, $user_id)
    {
//        $response=new \stdClass();
//        if(empty($item_id)){
//            $response->success=false;
//            $response->message="Invalid comment selection";
//            return $response;
//        }
//
//        if(empty($user_id)){
//            $response->success=false;
//            $response->message="user_id is required";
//            return $response;
//        }
//
//        $item=$this->commentRepo->find($item_id);
//        if($item){
//            if($item->created_by==$user_id || $this->itemRepo->isAdmin($user_id) || $this->itemRepo->isSuperAdmin($user_id)){
//                $query=$this->deleteRepo->performDelete($item_id,'action_item');
//                if($query){
//                    $response->success=true;
//                    $response->message="Action item has been deleted";
//                }
//                else{
//                    $response->success=false;
//                    $response->message="Something went wrong, try again later";
//                }
//            }
//            else{
//                $response->success=false;
//                $response->message="You don't have enough permission to delete the action item";
//            }
//        }
//        else{
//            $response->success=false;
//            $response->message="Comment not found";
//        }
//
//        return $response;
    }
}
