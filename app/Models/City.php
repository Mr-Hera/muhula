<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $table = 'cities';
    protected $guarded = [];

    public function getTotalSchool(){

        return $this->hasMany('App\Models\SchoolMaster','town','id')->where('status','A');
   }
}
