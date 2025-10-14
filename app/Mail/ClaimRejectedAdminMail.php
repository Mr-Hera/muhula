<?php

namespace App\Mail;

use App\Models\User;
use App\Models\School;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class ClaimRejectedAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $school;
    public $dashboardUrl;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, School $school, string $dashboardUrl)
    {
        $this->user = $user;
        $this->school = $school;
        $this->dashboardUrl = $dashboardUrl;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Claim for ' . $this->school->name . ' has been rejected',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.claims.rejected_admin_claim_notification',
            with: [
                'user' => $this->user,
                'school' => $this->school,
                'dashboardUrl' => $this->dashboardUrl,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
