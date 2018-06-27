<?php

namespace App\Services;


use App\Repositories\Contracts\AttachmentRepository;
use App\Repositories\MediaRepository;
use App\Services\Contracts\AttachmentServiceInterface;
use Illuminate\Support\Facades\DB;

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
        $response=new \stdClass();
        if(empty($request->get('created_by'))){
            $response->success=false;
            $response->message="user_id is required";
            return $response;
        }

        $data=$request->all();
        $data['created_by']=$request->user_id;

        if($request->has('image') && $request->get('image') != null)
        {
            DB::beginTransaction();
            $file = $request->get('image');
            $image_base64 = base64_decode($file);
            $extension=$media['mime_type']=$file->getClientOriginalExtension();
            $name =$media['file_name']= time() . rand(100,999) . $extension;
            $path = public_path() . '/uploads/organization/' . $name;
            $media['name']=url('/uploads/organization').'/'.$name;
            if(file_put_contents($path, $image_base64)){
                $this->mediaRepo->create($media);
            }

            $data['url']=url($media['name']);

            $query=$this->attachmentRepo->create($data);
            if($query){
                DB::commit();
                $response->success=true;
                $response->message="Attachment has been added";
            }
            else{
                DB::rollBack();
                $response->success=false;
                $response->message="Something went wrong, try again later";
            }

        }
        else{
            $response->success=false;
            $response->message="No attachment found";
        }

        return $response;
    }

    public function delete($attachment_id, $user_id)
    {
        $response=new \stdClass();
        if(empty($attachment_id)){
            $response->success=false;
            $response->message="Invalid attachment selection";
            return $response;
        }

        if(empty($user_id)){
            $response->success=false;
            $response->message="user_id is required";
            return $response;
        }

        DB::beginTransaction();
        $attachment=$this->attachmentRepo->find($attachment_id);
        if($attachment){
            if($attachment->created_by==$user_id || $this->attachmentRepo->isAdmin($user_id) || $this->attachmentRepo->isSuperAdmin($user_id)){
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
                $response->message="You don't have enough permission to delete the attachment";
            }
        }
        else{
            DB::rollBack();
            $response->success=false;
            $response->message="Attachment not found";
        }

        return $response;
    }
}