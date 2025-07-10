<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolToType extends Model
{
    use HasFactory;
    protected $table = 'school_to_type';
    protected $guarded = [];
}
