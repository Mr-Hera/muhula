<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolExamPerformance extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'exam',
        'ranking_position',
        'region',
        'mean_score_points',
        'mean_grade',
        'number_of_candidates',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
