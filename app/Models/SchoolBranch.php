<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolBranch extends Model
{
    use HasFactory;

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
}
