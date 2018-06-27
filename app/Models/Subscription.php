<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable=[
        'employee_id',
        'gateway_id',
        'is_active'
    ];

    public function employee(){
        return $this->belongsTo(Employee::class);
    }
}
