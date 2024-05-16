<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class OTPMail extends Mailable
{
    use Queueable, SerializesModels;
     public $otp;
     public $email;
     public $subject;
    /**
     * Create a new message instance.
     */
    public function __construct($email, $otp, $subject)
    {
         $this->otp= $otp;
         $this->email = $email;
         $this->subject=$subject;
    }

    public function build()
    {
        return $this->view('name')
                    ->subject($this->subject)
                    ->with(['otp' => $this->otp, 'email' => $this->email]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('sample@gmail.com', 'Menchie'),
            subject: 'Your OTP Code',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'name',
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
