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

class ClaimApprovedUserMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $school;
    public $viewSchoolUrl;
    public $dashboardUrl;

    

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, School $school)
    {
        $this->user = $user;
        $this->school = $school;

        // Generate correct URLs using named routes
        $this->viewSchoolUrl = route('school.details', ['slug' => $school->slug]);
        $this->dashboardUrl  = route('user.dashboard');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your claim for ' . $this->school->name . ' has been approved',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.claims.approved_user_claim_notification',
            with: [
                'user' => $this->user,
                'school' => $this->school,
                'viewSchoolUrl' => $this->viewSchoolUrl,
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
