<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'featured_image',
        'contact_person',
        'is_archived'
    ];

    public function departments()
    {
        return $this->hasMany(Department::class);
    }

    public function employees()
    {
        return $this->hasManyThrough(Employee::class, Department::class);
    }

//    public function admins()
//    {
//        return $this->belongsToMany(Admin::class,'');
//    }

    public function organizationAdmin(){
        return $this->hasOne(OrganizationAdmin::class,'organization_id','id');
    }

    public function project(){
        return $this->hasMany(Project::class);
    }
}
