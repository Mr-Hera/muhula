<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolRelationship extends Model
{
    use HasFactory;

    protected $table = 'school_relationship';
    protected $guarded = [];
}
