<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolToBoard extends Model
{
    use HasFactory;
    protected $table = 'school_to_board';
    protected $guarded = [];

    public function getBoard(){

         return $this->hasOne('App\Models\Board','id','board_id');
    }
}
