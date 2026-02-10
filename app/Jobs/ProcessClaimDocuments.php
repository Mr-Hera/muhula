<?php

namespace App\Jobs;

use App\Enums\ClaimStatus;
use App\Models\SchoolUser;
use Smalot\PdfParser\Parser;
use Illuminate\Bus\Queueable;
use App\Mail\ClaimAutoApprovedMail;
use App\Mail\ClaimManualReviewMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use App\Mail\AdminClaimAutoApprovedMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessClaimDocuments implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public int $claimId)
    {
        //
    }

    public function handle(): void
    {
        // Load school relation (NEW)
        $claim = SchoolUser::with(['user', 'school'])->findOrFail($this->claimId);

        $parser = new Parser();
        $requiredPhrases = config('claim.required_phrases');

        $score = 0;
        $matched = [];

        // NEW: normalize school name once
        $schoolName = strtoupper(trim($claim->school->name));
        $schoolFound = false;

        foreach ($claim->proof_of_association as $path) {
            $pdf = $parser->parseFile(storage_path('app/public/' . $path));
            $text = strtoupper($pdf->getText());

            /**
             * -----------------------------------
             * SCHOOL NAME CHECK (NEW)
             * -----------------------------------
             */
            if (!$schoolFound && str_contains($text, $schoolName)) {
                $schoolFound = true;
                $matched[] = 'School name detected';
                $score += 40; // weight for school match
            }

            foreach ($requiredPhrases as $phrase) {
                if (str_contains($text, strtoupper($phrase))) {
                    $matched[] = $phrase;
                    $score += 25;
                }
            }
        }

        /**
         * HARD FAIL if school name not found
         */
        if (!$schoolFound) {
            $claim->update([
                'auto_verification_result' => [
                    'score' => 0,
                    'matched_phrases' => [],
                    'school_name_found' => false,
                    'checked_at' => now(),
                ],
                'claim_status' => ClaimStatus::ManualReview,
            ]);

            Mail::to($claim->user->email)->send(new ClaimManualReviewMail($claim));
            Mail::to(config('mail.admin_address'))->send(new ClaimManualReviewMail($claim));

            return;
        }

        $result = [
            'score' => $score,
            'matched_phrases' => array_unique($matched),
            'school_name_found' => true,
            'checked_at' => now(),
        ];

        $claim->update([
            'auto_verification_result' => $result,
            'claim_status' => ClaimStatus::DocumentsVerified,
        ]);

        $this->finalizeDecision($claim, $score);
    }

    protected function finalizeDecision(SchoolUser $claim, int $score): void
    {
        if ($score >= config('claim.approval_score')) {
            $claim->update([
                'claim_status' => ClaimStatus::AutoApproved,
                'auto_approved' => true,
            ]);

            Mail::to($claim->user->email)->send(new ClaimAutoApprovedMail($claim));
            Mail::to(config('mail.admin_address'))->send(new AdminClaimAutoApprovedMail($claim));
        } else {
            $claim->update([
                'claim_status' => ClaimStatus::ManualReview,
            ]);

            Mail::to($claim->user->email)->send(new ClaimManualReviewMail($claim));
            Mail::to(config('mail.admin_address'))->send(new ClaimManualReviewMail($claim));
        }
    }
}
