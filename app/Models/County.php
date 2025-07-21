<?php

namespace App\Models;

use App\Models\Ward;
use App\Models\Constituency;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class County extends Model
{
    use HasFactory;

    public function constituencies() 
    { 
        return $this->hasMany(Constituency::class); 
    }
    
    public function wards() 
    { 
        return $this->hasManyThrough(Ward::class, Constituency::class); 
    }

    public function schools()
    {
        return $this->hasMany(School::class);
    }
}
