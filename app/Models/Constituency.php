<?php

namespace App\Models;

use App\Models\Ward;
use App\Models\County;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Constituency extends Model
{
    use HasFactory;

    public function county() 
    { return $this->belongsTo(County::class); 
    }
    
    public function wards() 
    { return $this->hasMany(Ward::class); 
    }
}
