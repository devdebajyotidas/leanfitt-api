<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActionItem extends Model
{
    protected $hidden=[
        'itemable_id',
        'itemable_type',
        'created_by'
    ];
    protected $fillable=[
        'name',
        'board_id',
        'assignor_id',
        'position',
        'due_date',
        'is_archived',
        'description',
        'created_by',
        'itemable_id',
        'itemable_type',
    ];

    public function assignor()
    {
        return $this->belongsTo(User::class,'assignor_id','id'); //assignor can be admin or employee
    }

    public function board(){
        return $this->belongsTo(Board::class);
    }

    public function checklist(){
        return $this->hasMany(Checklist::class);
    }

    public function label(){
        return $this->hasMany(Label::class);
    }

    public function member(){
        return $this->hasMany(ActionItemAssignee::class);
    }

    public function project()
    {
        return $this->morphTo(Project::class,'itemable_type','itemable_id');
    }

    public function comments(){
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function attachments(){
        return $this->morphMany(Attachment::class,'attachable');
    }

    public function assignments(){
        return $this->hasMany(ActionItemAssignment::class,'action_item_id','id');
    }

}
