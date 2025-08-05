<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolOperationHour extends Model
{
    use HasFactory;
    protected $fillable = ['period_of_day', 'starts_at', 'ends_at', 'school_id'];

}
