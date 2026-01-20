<?php

namespace App\Http\Controllers;

use App\Enums\ClaimStatus;
use App\Models\SchoolUser;
use Illuminate\Http\Request;
use App\Jobs\ProcessClaimDocuments;

class SchoolClaimController extends Controller
{
    public function verifyEmail(string $token) {
        $claim = SchoolUser::where('verification_token', $token)->firstOrFail();

    $claim->update([
        'email_verified_at' => now(),
        'verification_token' => null,
        'claim_status' => ClaimStatus::EmailVerified,
    ]);

    ProcessClaimDocuments::dispatch($claim->id);

    return redirect('/')->with('success', 'Email verified. Documents are being reviewed.');
    }
}
