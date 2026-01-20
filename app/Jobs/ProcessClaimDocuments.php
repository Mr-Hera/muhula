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
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessClaimDocuments implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public int $claimId)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $claim = SchoolUser::with('user')->findOrFail($this->claimId);

        $parser = new Parser();
        $requiredPhrases = config('claim.required_phrases');

        $score = 0;
        $matched = [];

        foreach ($claim->proof_of_association as $path) {
            $pdf = $parser->parseFile(storage_path('app/public/' . $path));
            $text = strtoupper($pdf->getText());

            foreach ($requiredPhrases as $phrase) {
                if (str_contains($text, strtoupper($phrase))) {
                    $matched[] = $phrase;
                    $score += 25;
                }
            }
        }

        $result = [
            'score' => $score,
            'matched_phrases' => array_unique($matched),
            'checked_at' => now(),
        ];

        $claim->update([
            'auto_verification_result' => $result,
            'claim_status' => ClaimStatus::DocumentsVerified,
        ]);

        // optional email domain scoring
        // $schoolDomain = parse_url($claim->school->website, PHP_URL_HOST);

        // if ($schoolDomain && str_contains($claim->email_domain, $schoolDomain)) {
        //     $score += 30;
        // }

        $this->finalizeDecision($claim, $score);
    }

    protected function finalizeDecision(SchoolUser $claim, int $score): void
    {
        if ($score >= config('claim.approval_score')) {
            $claim->update([
                'claim_status' => ClaimStatus::AutoApproved,
                'auto_approved' => true,
            ]);

            // Notify User
            Mail::to($claim->user->email)->send(new ClaimAutoApprovedMail($claim));

            // Notify Admin
            Mail::to(config('mail.admin_address'))->send(new ClaimAutoApprovedMail($claim));
        } else {
            $claim->update([
                'claim_status' => ClaimStatus::ManualReview,
            ]);

            // Notify User
            Mail::to($claim->user->email)->send(new ClaimManualReviewMail($claim));

            // Notify Admin
            Mail::to(config('mail.admin_address'))->send(new ClaimManualReviewMail($claim));
        }
    }
}
