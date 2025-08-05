<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolUniform extends Model
{
    use HasFactory;

    public function schools()
    {
        return $this->hasMany(School::class, 'school_uniform_id');
    }
}
