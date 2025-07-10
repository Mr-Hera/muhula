<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolSubject extends Model
{
    use HasFactory;

    protected $table = 'school_subject';
    protected $guarded = [];

    public function school_subjects()
    {
        return $this->belongsToMany('App\Models\Subject','school_to_subject');
    }

    public function getBoard(){

         return $this->hasOne('App\Models\Board','id','curriculum');
    }
    public function getClassLevel(){

        return $this->hasOne('App\Models\ClassLevel','id','class_level');
   }
}
