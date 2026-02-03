<?php

namespace App\Models;

use App\Models\SchoolImage;
use App\Models\SchoolAddress;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SchoolBranch extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'school_id',
        'school_type_id',
        'county_id',
        'school_address_id',
        'school_image_id',
        'email',
        'phone_no',
    ];

    // Define the relationship to School
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    // Define the relationship to School
    public function type()
    {
        return $this->belongsTo(SchoolType::class);
    }

    // Define the relationship to School
    public function county()
    {
        return $this->belongsTo(County::class);
    }

    // Branch belongs to an Address
    public function address()
    {
        return $this->belongsTo(SchoolAddress::class, 'school_address_id'); 
        // 'school_address_id' is the FK in school_branches
    }

    // Branch belongs to an Image (if you need)
    public function image()
    {
        return $this->belongsTo(SchoolImage::class, 'school_image_id');
    }
}
