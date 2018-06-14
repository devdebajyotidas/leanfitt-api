<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $table=[
        'employee_id',
        'subscription_id',
        'is_subscribed'
    ];

    public function employee(){
        return $this->belongsTo(Employee::class);
    }
}
