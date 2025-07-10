<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolToFacilities extends Model
{
    use HasFactory;

    protected $table = 'school_to_facilities';
    protected $guarded = [];

    public function getFacilities(){

         return $this->hasOne('App\Models\Facilities','id','facilities_id');
    }

}
