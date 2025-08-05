<?php

namespace App\Models;

use App\Models\Ward;
use App\Models\County;
use App\Models\Course;
use App\Models\Curriculum;
use App\Models\SchoolType;
use App\Models\SchoolImage;
use App\Models\SchoolLevel;
use App\Models\Constituency;
use App\Models\SchoolPopulation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class School extends Model
{
    use HasFactory;
    protected $fillable = [
        'year_of_establishment',
        'name',
        'description',
        'slug',
        'religion_id',
        'county_id',
        'country_id',
        'school_uniform_id',
        'school_contact_id',
        'school_address_id',
        'constituency_id',
        'ward_id',
        'school_level_id',
        'school_type_id',
        'curriculum_id',
        'school_operation_hour_id',
        'extended_school_service_id',
        'ownership',
        'gender_admission',
        'logo',
        'website_url',
        'is_active',
    ];

    public function schoolLevel()
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
        return $this->belongsToMany(Facility::class, 'school_facilities')->withTimestamps();
    }

    public function branches()
    {
        return $this->hasMany(SchoolBranch::class);
    }

    public function uniform()
    {
        return $this->belongsTo(SchoolUniform::class, 'school_uniform_id');
    }

    public function operationHours()
    {
        return $this->hasMany(SchoolOperationHour::class);
    }

    public function extendedSchoolServices()
    {
        return $this->belongsToMany(ExtendedSchoolService::class, 'school_service');
    }

    public function population()
    {
        return $this->hasOne(SchoolPopulation::class);
    }

    public function images()
    {
        return $this->hasMany(SchoolImage::class);
    }

    public function examPerformances()
    {
        return $this->hasMany(SchoolExamPerformance::class);
    }
}
