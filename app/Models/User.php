<?php

namespace App\Models;

use App\Models\Ward;
use App\Models\County;
use App\Models\Curriculum;
use App\Models\Constituency;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function county() 
    { 
        return $this->belongsTo(County::class); 
    }
    
    public function constituency() 
    { 
        return $this->belongsTo(Constituency::class); 
    }
    
    public function ward() 
    { 
        return $this->belongsTo(Ward::class); 
    }
    
    public function curriculum() 
    { 
        return $this->belongsTo(Curriculum::class); 
    }
}
