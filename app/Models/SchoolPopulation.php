<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolPopulation extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'year',
        'total_students',
        'total_teachers',
        'male_students',
        'female_students',
        'male_teachers',
        'female_teachers',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
