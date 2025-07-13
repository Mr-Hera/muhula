<?php

namespace App\Models;

use App\Models\School;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SchoolType extends Model
{
    use HasFactory;

    protected $table = 'school_types';
    protected $guarded = [];

    public function getTotalSchool(){
         return $this->hasMany('App\Models\SchoolToType','school_type_id','id');
    }

    public function schools() 
    { 
        return $this->hasMany(School::class); 
    }
}
