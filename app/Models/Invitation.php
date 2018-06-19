<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $fillable=[
        'organization_id',
        'department_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'token',
        'is_joined'
    ];

    public function organization(){
        return $this->belongsTo(Organization::class);
    }
}
