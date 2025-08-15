<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Favourite extends Model
{
    use HasFactory;

    protected $table = 'favourites';
    protected $guarded = [];

    public function user() 
    { 
        return $this->belongsTo(User::class); 
    }
    
    public function favouritable() 
    { 
        return $this->morphTo(); 
    }
}
