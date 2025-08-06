<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'county_id',
        'name',
    ];

    public function schools()
    {
        return $this->hasMany(School::class);
    }
}
