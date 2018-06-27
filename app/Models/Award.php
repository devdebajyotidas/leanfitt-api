<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Award extends Model
{
    protected  $fillable=[
        'employee_id',
        'title',
        'type',
        'description'
    ];

    public function employee(){
        return $this->belongsTo(Employee::class);
    }
}
