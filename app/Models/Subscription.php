<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $table=[
        'employee_id',
        'subscription_id',
        'amount',
        'expiry_date',
        'plan_type'
    ];

    public function employee(){
        return $this->belongsTo(Employee::class);
    }
}
