<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizationAdmin extends Model
{
    protected $table = 'organization_admin';

    public $timestamps = false;

    protected $fillable = [
        'organization_id',
        'admin_id',
    ];

    public function admin(){
        return $this->belongsTo(Admin::class);
    }

    public function organization(){
        return $this->belongsTo(Organization::class);
    }
}
