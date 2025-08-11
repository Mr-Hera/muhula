<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'latitude',
        'longitude',
        'google_maps_link',
        'address_text',
    ];
}
