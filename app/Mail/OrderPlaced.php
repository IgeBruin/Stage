<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Order;

class OrderPlaced extends Mailable
{
    use SerializesModels;
    use InteractsWithQueue;

    protected $order;
    public $pdfData;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order, $pdfData)
    {
        //
        $this->order = $order;
        $this->pdfData = $pdfData;
    }

    public function build()
    {
        return $this->subject('Bestelling geplaatst')->attachData($this->pdfData, 'factuur.pdf', [
        'mime' => 'application/pdf',
        ])
        ->from('igebruib@gmail.com', 'Ige Bruin')
        ->markdown('emails.orders.placed');
    }
    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Order Placed',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'view.name',
            with: ['order' => $this->order]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
