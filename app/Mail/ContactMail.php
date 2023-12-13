<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $data;
    public $visitorName;
    public $visitorEmail;
    public $visitorPhone;
    public $visitorMessage;
    public $car;

/**
 * Create a new message instance.
 *
 * @return void
 */
    public function __construct($data)
    {
        $this->data = $data;

        $this->visitorName = $data['name'];
        $this->visitorEmail = $data['email'];
        $this->visitorPhone = $data['phone'];
        $this->visitorMessage = $data['message'];
        $this->car = $data['car'];
    }
    
    

    public function build()
    {
        return $this->view('emails.interested')->subject('U heeft een reactie ontvangen op uw advertentie')
        ->from('mailofsender@gmail.com', 'name of sender here')
        ->markdown('emails.cars.interested');
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Contact Mail',
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
            with: ['car' => $this->car]
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
