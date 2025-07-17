<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function build() {
        return $this->subject('Welcome to OutfitOn!')
            ->view('emails.verify_email')
            ->with([
                'name' => $this->user->name,
                'email' => $this->user->email,
                'created_at' => $this->user->created_at,
            ]);
    }
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Welcome Mail',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.verify_email',
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
