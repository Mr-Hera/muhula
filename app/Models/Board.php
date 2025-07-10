<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    use HasFactory;

    protected $table = 'board';
    protected $guarded = [];

    public function getTotalSchool(){

         return $this->hasMany('App\Models\SchoolMaster','board_id','id')->where('status','A');
    }
}
