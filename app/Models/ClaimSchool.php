<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClaimSchool extends Model
{
    use HasFactory;
    protected $table = 'claim_school';
    protected $guarded = [];

    public function getSchool(){

        return $this->hasOne('App\Models\SchoolMaster','id','school_id');
    }
    public function getUser(){

         return $this->hasOne('App\User','id','user_id');
    }
    public function getSchoolOwner(){

         return $this->hasOne('App\User','id','school_owner_id');
    }
    public function getClaimDoc(){

        return $this->hasMany('App\Models\ClaimDocument','claim_id','id');
   }
}
