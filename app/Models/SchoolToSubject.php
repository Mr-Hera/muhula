<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolToSubject extends Model
{
    use HasFactory;

    protected $table = 'school_to_subject';
    protected $guarded = [];
}
