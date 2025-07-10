<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $table = 'reviews';
    protected $guarded = [];

    public function getUser(){

         return $this->hasOne('App\User','id','user_id');
    }

    public function getSchool(){

         return $this->hasOne('App\Models\SchoolMaster','id','school_id');
    }
}
