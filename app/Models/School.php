<?php

namespace App\Models;

use App\Models\Ward;
use App\Models\County;
use App\Models\Course;
use App\Models\Curriculum;
use App\Models\SchoolType;
use App\Models\SchoolLevel;
use App\Models\Constituency;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class School extends Model
{
    use HasFactory;

    public function level() 
    { 
        return $this->belongsTo(SchoolLevel::class); 
    }
    
    public function type() 
    { 
        return $this->belongsTo(SchoolType::class); 
    }
    
    public function curriculum() 
    { 
        return $this->belongsTo(Curriculum::class); 
    }
    
    public function county() 
    { 
        return $this->belongsTo(County::class); 
    }
    
    public function constituency() 
    { 
        return $this->belongsTo(Constituency::class); 
    }
    
    public function ward() 
    { 
        return $this->belongsTo(Ward::class); 
    }
    
    public function courses() 
    { 
        return $this->belongsToMany(Course::class, 'school_courses'); 
    }

    public function facilities()
    {
        return $this->belongsToMany(Facility::class)->withTimestamps();
    }
}
