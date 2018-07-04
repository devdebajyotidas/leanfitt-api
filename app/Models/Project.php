<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable=[
        'organization_id',
        'name',
        'goal',
        'leader',
        'lean_sensie',
        'start_date',
        'end_date',
        'report_date',
        'note',
        'is_archived',
        'is_completed',
        'created_by'
    ];

    public function leaderData(){
        return $this->hasOne(User::class,'id','leader');
    }

    public function sensie(){
        return $this->hasOne(User::class,'id','lean_sensie');
    }

    public function kpi(){
        return $this->hasMany(KpiChart::class);
    }

    public function actionItem(){
        return $this->morphMany(ActionItem::class,'itemable');
    }

    public function organization(){
        return $this->belongsTo(Organization::class);
    }

    public function activity(){
        return $this->hasMany(ProjectActivity::class);
    }

    public function comments(){
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function attachments(){
        return $this->morphMany(Attachment::class,'attachable');
    }

    public function reports(){
        return $this->hasMany(Report::class);
    }
}
