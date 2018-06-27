<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'name',
        'organization_id',
        'is_archived',
        'created_by'
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

}
