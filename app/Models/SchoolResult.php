<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolResult extends Model
{
    use HasFactory;

    protected $table = 'school_result';
    protected $guarded = [];

    public function getResultDetail(){

         return $this->hasMany('App\Models\SchoolResultDetail','school_result_id','id');
    }

    public function getBoard(){

         return $this->hasOne('App\Models\Board','id','board_id');
    }
}
