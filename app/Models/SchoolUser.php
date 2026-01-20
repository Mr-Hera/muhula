<?php

namespace App\Models;

use App\Models\User;
use App\Models\School;
use App\Enums\ClaimStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SchoolUser extends Model
{
    use HasFactory;

    protected $table = 'school_user';

    protected $casts = [
        'claim_status' => ClaimStatus::class,
        'auto_verification_result' => 'array',
        'proof_of_association' => 'array',
    ];

    protected $fillable = [
        'user_id',
        'school_id',
        'contact_position_id',
        'proof_of_association',
        'claim_status',
        'email_domain',
        'verification_token',
        'email_verified_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
