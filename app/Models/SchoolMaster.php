<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolMaster extends Model
{
    use HasFactory;

    protected $table = 'school_master';
    protected $guarded = [];

    public function getSchoolType(){

         return $this->hasOne('App\Models\SchoolType','id','school_type_id');
    }
    public function school_types()
    {
        return $this->belongsToMany('App\Models\SchoolType','school_to_type');
    }
    public function school_boards()
    {
        return $this->belongsToMany('App\Models\Board','school_to_board');
    }
    public function getSchoolBoard(){

        return $this->hasOne('App\Models\SchoolToBoard','school_master_id','id');
   }
   public function getSchoolLanguage(){

    return $this->hasOne('App\Models\Language','id','language_instruction_id');
  }
   public function getUser(){

       return $this->hasOne('App\User','id','user_id');
   }
   public function getCountry(){

    return $this->hasOne('App\Models\Country','id','country');
  }
  public function getTown(){

    return $this->hasOne('App\Models\City','id','town');
  }
  public function getSchoolMainImage(){

    return $this->hasOne('App\Models\SchoolGallery','school_master_id','id');
  }
  public function getSchoolImages(){

    return $this->hasMany('App\Models\SchoolGallery','school_master_id','id');
  }
  public function getSchoolBranchMainImage(){

    return $this->hasOne('App\Models\SchoolBranchImage','school_branch_id','id');
  }
  public function getSchoolFees(){

      return $this->hasMany('App\Models\SchoolFees','school_master_id','id');
  }
  public function getReligion(){

    return $this->hasOne('App\Models\Religion','id','religion_id');
  }
  public function getRelationship(){

    return $this->hasOne('App\Models\SchoolRelationship','id','relationship_id');
  }
  public function getClaim(){

    return $this->hasOne('App\Models\ClaimSchool','school_id','id');
  }
}
