<?php

namespace App\Mail;

use App\Models\School;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class AdminNewClaimNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public School $school;
    public string $userName;
    public string $userEmail;

    /**
     * Create a new message instance.
     */
    public function __construct(School $school, string $userName, string $userEmail)
    {
        $this->school = $school;
        $this->userName = $userName;
        $this->userEmail = $userEmail;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New School Claim Pending Review',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.claims.admin_submitted_claim_notification',
            with: [
                'schoolName' => $this->school->name,
                'userName' => $this->userName,
                'userEmail' => $this->userEmail,
                'reviewUrl' => route('get.manage.claims'),
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
