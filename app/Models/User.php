<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UserAttributes;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
//    use UserAttributes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'avatar',
        'password',
        'verification_token',
        'is_verified',
        'is_archived'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public static $rules = [
        "create" => [
            'email' => 'email|unique:users',
            'password' => 'required|confirmed|min:6',
        ],
        "update" => [
            'email' => 'email',
            'password' => 'confirmed|min:6',
        ],

    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    public function item(){
        return $this->hasMany(ActionItem::class);
    }

    public function assignee(){
        return $this->hasMany(ActionItemAssignee::class);
    }

    public function comment(){
        return $this->hasMany(Comment::class);
    }

    public function quizResult(){
        return $this->hasMany(QuizResult::class);
    }

    public function project(){
        return $this->belongsTo(Project::class);
    }

    public function quiz(){
        return $this->hasManyThrough(QuizResult::class, Employee::class);
    }

    public function award(){
        return $this->hasManyThrough(Award::class, Employee::class);
    }

}
