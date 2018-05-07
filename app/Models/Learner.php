<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Learner extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'department_id',
        'organization_id',
        'account_id',
        'designation'
    ];
}
