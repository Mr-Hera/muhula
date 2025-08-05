<?php

namespace App\Models;

use App\Models\School;
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

    public function schools()
    {
        return $this->belongsToMany(School::class, 'school_courses')->withTimestamps();
    }
}
