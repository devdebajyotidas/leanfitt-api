<?php


namespace App\Services;


use App\Repositories\CommentRepository;
use App\Services\Contracts\CommentServiceInterface;
use App\Validators\CommentValidator;
use Illuminate\Support\Facades\DB;

class CommentService implements CommentServiceInterface
{
   protected $commentRepo;
   public function __construct(CommentRepository $commentRepository)
   {
       $this->commentRepo=$commentRepository;
   }

   public function create($request)
   {
       $response=new \stdClass();
       $data=$request->all();
       $validator=new CommentValidator($data,'create');
       if($validator->fails()){
           $response->success=false;
           $response->message=$validator->messages()->first();
           return $response;
       }

       if($data['type']=='action_item'){
           if(empty($request->get('action_item_id'))){
               $response->success=false;
               $response->message="action_item_id is required";
               return $response;
           }

           $data['commentable_type']='App\Models\ActionItem';
           $data['commentable_id']=$request->get('action_item_id');
       }
       else{
           if(empty($request->get('project_id'))){
               $response->success=false;
               $response->message="project_id is required";
               return $response;
           }

           $data['commentable_type']='App\Models\Project';
           $data['commentable_id']=$request->get('project_id');
       }

       DB::beginTransaction();
       $data['created_by']=$data['user_id'];
       $query=$this->commentRepo->create($data);
       if($query){
           DB::commit();
           $response->success=true;
           $response->message="Comment has been posted";
       }
       else{
           DB::rollBack();
           $response->success=false;
           $response->message="Something went wrong, try again later";
       }

       return $response;
   }

   public function update($request, $comment_id)
   {
       $response=new \stdClass();;
       if($comment_id){
           $response->success=false;
           $response->message="Invalid comment selection";
           return $response;
       }

       DB::beginTransaction();
       $query=$this->itemRepo->update($comment_id,$request->all());
       if($query){
           DB::commit();
           $response->success=true;
           $response->message="Comment has been updated";
       }
       else{
           DB::rollBack();
           $response->success=false;
           $response->message="Something went wrong, try again later";
       }

       return $response;
   }

   public function delete($comment_id, $user_id)
   {
       $response=new \stdClass();
       if(empty($comment_id)){
           $response->success=false;
           $response->message="Invalid comment selection";
           return $response;
       }

       if(empty($user_id)){
           $response->success=false;
           $response->message="user_id is required";
           return $response;
       }

       DB::beginTransaction();
       $comment=$this->commentRepo->find($comment_id);
       if($comment){
           if($comment->created_by==$user_id || $this->commentRepo->isAdmin($user_id) || $this->commentRepo->isSuperAdmin($user_id)){
               $query=$this->commentRepo->deleteQuery($comment);
               if($query){
                   DB::commit();
                   $response->success=true;
                   $response->message="Comment has been deleted";
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
               $response->message="You don't have enough permission to delete the comment";
           }
       }
       else{
           DB::rollBack();
           $response->success=false;
           $response->message="Comment not found";
       }

       return $response;
   }
}