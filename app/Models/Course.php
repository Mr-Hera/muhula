<?php

namespace App\Models;

use App\Models\SchoolCourse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;

    public function schoolCourses() 
    { 
        return $this->hasMany(SchoolCourse::class); 
    }
}
