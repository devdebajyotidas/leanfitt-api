<?php

namespace App\Services;


use App\Repositories\Contracts\AttachmentRepository;
use App\Repositories\MediaRepository;
use App\Services\Contracts\AttachmentServiceInterface;
use App\Validators\AttachmentValidator;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\FilesystemManager;
use Spatie\Backup\Helpers\File;

class AttachmentService implements AttachmentServiceInterface
{
    protected $attachmentRepo;
    protected $mediaRepo;
    public function __construct(AttachmentRepository $attachmentRepository,
                                MediaRepository $mediaRepository)
    {
        $this->attachmentRepo=$attachmentRepository;
        $this->mediaRepo=$mediaRepository;
    }

    public function create($request)
    {
        $fileSystem=new Filesystem();
        $data=$request->all();
        $response=new \stdClass();
        $validator=new AttachmentValidator($request->all(),'create');
        if($validator->fails()){
            $response->success=false;
            $response->message=$validator->messages()->first();
            return $response;
        }

        if(empty($request->file('file'))){
            $response->success=false;
            $response->message='file is required';
            return $response;
        }

        if($request->type=='project'){
            if(empty($request->get('project_id'))){
                $response->success=false;
                $response->message='project_id is required';
                return $response;
            }

            $data['attachable_type']='App\Models\Project';
            $data['attachable_id']=$request->project_id;
        }
        else{
            if(empty($request->get('action_item_id'))){
                $response->success=false;
                $response->message='action_item_id is required';
                return $response;
            }

            $data['attachable_type']='App\Models\ActionItem';
            $data['attachable_id']=$request->action_item_id;
        }

        DB::beginTransaction();
        $file=$request->file('file');
        $data['path']=$path=Storage::putFile('public/attachments',$file);
        $data['url']=url(Storage::url($path));

        $attachment=$this->attachmentRepo->create($data);
        if($attachment){
            $media['mime_type']=$fileSystem->mimeType($file);
            $media['size']=$fileSystem->size($file);
            $media['file_name']=basename($path);
            $this->mediaRepo->create($media);

            DB::commit();
            $response->success=true;
            $response->message="Attachment has been added";
        }
        else{
            DB::rollBack();
            $response->success=false;
            $response->message="Something went wrong, try again later";
        }

        return $response;
    }

    public function delete($attachment_id, $user_id)
    {
        $response=new \stdClass();
        if(empty($attachment_id)){
            $response->success=false;
            $response->message="attachment_id is required";
            return $response;
        }

        if(empty($user_id)){
            $response->success=false;
            $response->message="user_id is required";
            return $response;
        }

        $attachment=$this->attachmentRepo->find($attachment_id);
        if($attachment){
            if($attachment->created_by==$user_id || $this->attachmentRepo->isAdmin($user_id) || $this->attachmentRepo->isSuperAdmin($user_id)){
                $file_exists = Storage::disk('local')->exists($attachment->path);
                if(!$file_exists){
                    $response->success=false;
                    $response->message="Attachment not found";
                    return $response;
                }

                DB::beginTransaction();
                $file_delete=Storage::disk('local')->delete($attachment->path);
                if($file_delete){
                    $query=$this->attachmentRepo->forceDeleteRecord($attachment);
                    if($query){
                        DB::commit();
                        $response->success=true;
                        $response->message="Attachment has been removed";
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
                $response->success=false;
                $response->message="You don't have enough permission to delete the attachment";
            }
        }
        else{
            $response->success=false;
            $response->message="Attachment not found";
        }

        return $response;
    }
}