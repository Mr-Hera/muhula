<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    protected $fillable = [
        'name',
    ];
    use HasFactory;
    
    public function schools()
    {
        return $this->belongsToMany(School::class)->withTimestamps();
    }
}
