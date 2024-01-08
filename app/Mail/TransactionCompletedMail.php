<?php

namespace App\Mail;

use App\Http\Resources\TransactionResource;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TransactionCompletedMail extends Mailable
{
    use Queueable, SerializesModels;
    private TransactionResource $transactionResource;

    /**
     * Create a new message instance.
     */
    public function __construct(TransactionResource $transactionResource)
    {
        $this->transactionResource = $transactionResource;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Transaction Confirmed',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.transaction.completed',
            with: [
                'invoice_number' => $this->transactionResource->invoice_number,
                'donation_type' => $this->transactionResource->donationType->name,
                'good_type' => $this->transactionResource->goodType->name,
                'amount' => $this->transactionResource->amount,
                'recipient_email' => $this->transactionResource->donor->email,
                'donorable_type' => $this->transactionResource->donor->donorable_type
            ]
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
