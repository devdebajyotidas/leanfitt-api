<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportDefault extends Model
{
    protected $fillable=[
        'type',
        'label',
        'level',
        'report_category_id'
    ];

    public function elements(){
        return $this->hasMany(ReportDefaultElement::class);
    }

    public function assignment(){
        return $this->belongsTo(ReportDefaultAssignment::class,'id','report_default_id');
    }

    public function elementAssignment(){
        return $this->belongsTo(ReportElementAssignment::class);
    }

    public function category(){
        return $this->hasOne(ReportCategory::class);
    }
}
