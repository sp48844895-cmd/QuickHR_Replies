<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CandidateResponseMail extends Mailable
{
    use Queueable, SerializesModels;

    public $status;
    public $candidateName;
    public $position;

    /**
     * Create a new message instance.
     */
    public function __construct($status, $candidateName, $position)
    {
        $this->status = $status;
        $this->candidateName = $candidateName;
        $this->position = $position;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->status === 'selected' 
            ? 'Congratulations! You have been selected'
            : 'Thank you for your application';

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $view = $this->status === 'selected' 
            ? 'emails.selected'
            : 'emails.rejected';

        return new Content(
            view: $view,
            with: [
                'candidateName' => $this->candidateName,
                'position' => $this->position,
            ],
        );
    }
}
