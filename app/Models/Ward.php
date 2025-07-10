<?php

namespace App\Models;

use App\Models\Constituency;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ward extends Model
{
    use HasFactory;

    public function constituency() 
    { 
        return $this->belongsTo(Constituency::class); 
    }
}
