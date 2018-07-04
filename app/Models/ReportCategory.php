<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportCategory extends Model
{
    public $timestamps=false;

    protected $fillable=[
        'name'
    ];

    public function report(){
        return $this->belongsTo(Report::class);
    }
}
