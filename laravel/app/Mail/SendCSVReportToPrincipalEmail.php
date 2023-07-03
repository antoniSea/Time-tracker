<?php

namespace App\Mail;

use App\Models\Principal;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendCSVReportToPrincipalEmail extends Mailable
{
    use Queueable, SerializesModels;

    private string    $assetPath;
    private Principal $principal;

    /**
     * Create a new message instance.
     */
    public function __construct(
        string    $assetPath,
        Principal $principal,
    )
    {
        $this->assetPath = $assetPath;
        $this->principal = $principal;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Send CSV Report To Principal',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.csv-report-principal',
            with: [
                'assetPath' => $this->assetPath,
                'principal' => $this->principal
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
