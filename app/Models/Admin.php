<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UserAttributes;

class Admin extends Model
{
    use UserAttributes;

    protected $fillable = [
        'user_id',
        'is_superadmin',
    ];

    protected $appends = [
        'first_name',
        'last_name',
        'full_name',
        'email',
        'phone',
        'avatar',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function organizations()
    {
        return $this->belongsToMany(Organization::class);
    }

    public function organizationAdmin(){
        return $this->hasMany(OrganizationAdmin::class);
    }
}
