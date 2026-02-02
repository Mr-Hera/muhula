<?php

namespace App\Models;

use App\Models\Ward;
use App\Models\County;
use App\Models\Favourite;
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
        'first_name',
        'last_name',
        'email',
        'phone',
        'gender',
        'date_of_birth',
        'county_id',
        'constituency_id',
        'ward_id',
        'school_name',
        'curriculum_id',
        'profile_image',
        'email_verified_at',
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

    public function getIsEmailVerifiedAttribute(): bool
    {
        return ! is_null($this->email_verified_at);
    }

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

    public function claimedSchools()
    {
        return $this->belongsToMany(School::class, 'school_user')
            ->withPivot('claim_status', 'claimed_at')
            ->withTimestamps();
    }

    public function favourites()
    {
        return $this->hasMany(Favourite::class);
    }
}
