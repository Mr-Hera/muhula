<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolFees extends Model
{
    use HasFactory;

    protected $table = 'school_fees';
    protected $guarded = [];
}
