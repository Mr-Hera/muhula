<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolContact extends Model
{
    use HasFactory;

    protected $fillable = [
        'contact_position_id',
        'full_names',
        'email',
        'phone_no',
    ];
}
