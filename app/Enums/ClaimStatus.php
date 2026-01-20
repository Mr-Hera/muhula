<?php

namespace App\Enums;

enum ClaimStatus: string
{
    case Pending = 'pending';
    case EmailVerified = 'email_verified';
    case DocumentsVerified = 'documents_verified';
    case AutoApproved = 'auto_approved';
    case ManualReview = 'manual_review';
    case Rejected = 'rejected';
}
