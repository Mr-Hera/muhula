<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolImage extends Model
{
    use HasFactory;

    public function school() 
    { 
        return $this->belongsTo(School::class); 
    }
}
