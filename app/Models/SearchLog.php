<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SearchLog extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['search_term', 'user_id', 'level_id', 'type_id', 'county_id', 'curriculum_id'];
}
