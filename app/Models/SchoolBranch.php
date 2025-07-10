<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolBranch extends Model
{
    use HasFactory;

    protected $table = 'school_branches';
    protected $guarded = [];

    public function getCountry(){

          return $this->hasOne('App\Models\Country','id','country');
    }
    public function getBranchImage(){

        return $this->hasMany('App\Models\SchoolBranchImage','school_branch_id','id');
  }
}
