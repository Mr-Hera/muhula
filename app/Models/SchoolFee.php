<?php

namespace App\Models;

use App\Models\School;
use App\Models\SchoolLevel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SchoolFee extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'level_id',
        'min_amount',
        'max_amount',
        'currency',
    ];

    public function school() 
    { 
        return $this->belongsTo(School::class); 
    }

    public function level() 
    { 
        return $this->belongsTo(SchoolLevel::class); 
    }
}
