<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UserAttributes;

class Employee extends Model
{
    use UserAttributes;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'department_id',
        'organization_id',
        'designation',
        'is_archived'
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

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
