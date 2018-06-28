<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use App\Traits\UserAttributes;

class Employee extends Model
{
//    use UserAttributes;

    protected $fillable = [
        'user_id',
        'department_id',
        'designation',
        'is_archived'
    ];

//    protected $appends = [
//        'first_name',
//        'last_name',
//        'full_name',
//        'email',
//        'phone',
//        'avatar',
//    ];

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

    public function award(){
        return $this->hasMany(Award::class);
    }

    public function quiz(){
        return $this->hasMany(QuizResult::class);
    }

    public function subscription(){
        return $this->hasOne(Subscription::class);
    }
}
