<?php

namespace App\Models;

use App\Models\Course;
use App\Models\School;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SchoolCourse extends Model
{
    use HasFactory;

    public function school() { 
        return $this->belongsTo(School::class); 
    }
    
    public function course() { 
        return $this->belongsTo(Course::class); 
    }
}
