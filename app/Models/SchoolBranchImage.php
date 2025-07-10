<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolBranchImage extends Model
{
    use HasFactory;

    protected $table = 'school_branch_to_images';
    protected $guarded = [];
}
