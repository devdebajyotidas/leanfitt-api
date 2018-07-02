<?php

namespace App\Repositories;


use App\Models\ActionItem;
use App\Models\Attachment;
use App\Models\Comment;
use Illuminate\Support\Facades\DB;

class DeleteRepository
{
       public function deleteActionItems($type,$id){
           $del=0;
           if($type=='self') {
               $item = ActionItem::find($id);
               if (count($item) > 0) {
                   DB::beginTransaction();
                   $delCom = $this->deleteComments('action_item', $item->id);
                   $delAtt = $this->deleteAttachments('action_item', $item->id);
                   if ($delCom && $delAtt && $item->forceDelete()) {
                       DB::commit();
                       return true;
                   }
                   else{
                       DB::rollBack();
                       return false;
                   }
               }
           } else {
               $items = ActionItem::where('itemable_type', $this->getMorphType($type))->where('itemable_id', $id)->get();

               DB::beginTransaction();
               if (count($items) > 0) {
                   foreach ($items as $item) {
                       $delCom = $this->deleteComments('action_item', $item->id);
                       $delAtt = $this->deleteAttachments('action_item', $item->id);
                       if ($delCom && $delAtt && $item->forceDelete()) {
                           $del++;
                       }
                   }
               } else {
                   $del++;
               }

               if ($del > 0) {
                   DB::commit();
                   return true;
               } else {
                   DB::rollBack();
                   return false;
               }
           }
       }

       public function deleteComments($type,$id){
            $del=0;

            DB::beginTransaction();
            $comments=Comment::where('commentable_type',$this->getMorphType($type))->where('commentable_id',$id)->get();
            if(count($comments) > 0){
                foreach ($comments as $comment){
                    $delCom=$comment->forceDelete();
                    if($delCom){
                        $del++;
                    }
                }
            }
            else{
                $del++;
            }

            if($del > 0){
                DB::commit();
                return true;
            }
            else{
                DB::rollBack();
                return false;
            }
       }

       public function deleteAttachments($type,$id){
           $del=0;

           DB::beginTransaction();
           $attachments=Attachment::where('attachable_type',$this->getMorphType($type))->where('attachable_id',$id)->get();
           if(count($attachments) > 0){
               foreach ($attachments as $attachment){
                   $delAtch=$attachment->forceDelete();
                   if($delAtch){
                       $del++;
                   }
               }
           }
           else{
               $del++;
           }

           if($del > 0){
               DB::commit();
               return true;
           }
           else{
               DB::rollBack();
               return false;
           }
       }

       private function getMorphType($type){
           switch ($type){
               case('action_item'):
                  return 'App\Models\ActionItem';
                  break;
               case ('project'):
                   return 'App\Models\Project';
                   break;
               case('report'):
                   return 'App\Models\Report';
                   break;
               default:
                   return null;
                   break;
           }
       }

}