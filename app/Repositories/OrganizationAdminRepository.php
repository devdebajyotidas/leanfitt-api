<?php

namespace App\Repositories;

use App\Models\OrganizationAdmin;
use App\Repositories\Contracts\OrganizationAdminRepositoryInterface;
use Illuminate\Support\Collection;

class OrganizationAdminRepository extends BaseRepository implements OrganizationAdminRepositoryInterface
{
    public function model()
    {
        return new OrganizationAdmin();
    }

    public function AllOrganizationByAdmin($user)
    {
        $query=$this->model()->join('admins as ad','ad.id','=','organization_admin.admin_id')
            ->join('users as u','u.id','=','ad.user_id')
            ->join('organizations as o','o.id','=','organization_admin.organization_id')
            ->where('u.id',$user)
            ->select(['o.*'])->get();
        return $query;
    }

    public function firstOrganizationByAdmin($user_id,$organization=null)
    {
        $query=$this->model()->join('admins as ad','ad.id','=','organization_admin.admin_id')
            ->join('users as u','u.id','=','ad.user_id')
            ->join('organizations as o','o.id','=','organization_admin.organization_id')
            ->where('u.id',$user_id);

        if(!empty($organization)){
            $query=$query->where('o.id',$organization);
        }
        return $query->select(['o.*','ad.is_superadmin'])->first();
    }

}