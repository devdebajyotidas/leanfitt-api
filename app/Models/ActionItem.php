<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActionItem extends Model
{
    protected $fillable=[
      'name',
      'lean_tool_id',
      'board_id',
      'assignor_id',
      'position',
      'due_date',
      'is_archived',
      'description'
    ];

    protected $appends = [
        'first_name',
        'last_name',
        'full_name',
        'email',
        'phone',
        'avatar',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'id','assignor_id'); //assignor can be admin or employee
    }

    public function board(){
        return $this->belongsTo(Board::class);
    }

    public function tool(){
        return $this->belongsTo(LeanTool::class);
    }

    public function checklist(){
        return $this->hasMany(Checklist::class);
    }

    public function label(){
        return $this->hasMany(Label::class);
    }

    public function attachment(){
        return $this->hasMany(Attachment::class);
    }

    public function comment(){
        return $this->hasMany(Comment::class);
    }
}
