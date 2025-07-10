<?php

namespace App\Models;

use App\Models\User;
use App\Models\School;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SchoolReview extends Model
{
    use HasFactory;

    public function school() 
    { 
        return $this->belongsTo(School::class); 
    }
    
    public function user() 
    { 
        return $this->belongsTo(User::class); }
}
