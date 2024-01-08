<?php

namespace App\Mail;

use App\Http\Resources\TransactionResource;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TransactionInvoiceMail extends Mailable
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
            subject: 'Invoice',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.transaction.invoice',
            with: [
                'invoice_number' => $this->transactionResource->invoice_number,
                'donation_type' => $this->transactionResource->donationType->name,
                'good_type' => $this->transactionResource->goodType->name,
                'amount' => $this->transactionResource->amount,
                'donor_name' => $this->transactionResource->donor->name,
                'addtional_info' => $this->transactionResource->donor->donorable_type == 'App\Models\Resident' ? $this->transactionResource->donor->donorable->house_number : $this->transactionResource->donor->donorable->description,
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
