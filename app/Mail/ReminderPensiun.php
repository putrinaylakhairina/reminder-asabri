<?php

namespace App\Mail;

use App\Models\Pensioner;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReminderPensiun extends Mailable
{
    use Queueable, SerializesModels;

    public Pensioner $pensioner;

    /**
     * Create a new message instance.
     */
    public function __construct(Pensioner $pensioner)
    {
        $this->pensioner = $pensioner;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pengingat Pembayaran Dana Pensiun ASABRI',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.reminder-pensiun',
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
