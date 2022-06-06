<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderReceived extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $invoice;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order, $invoice) {
        $this->invoice = $invoice;
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->markdown('emails.orders.received', [
            'order' => $this->order,
        ])
        ->attachData($this->invoice->stream()->getContent(), 'Coder\'s_Shop_'.$this->order->confirmation_number.'.pdf', [
            'mime' => 'application/pdf',
        ]);
    }
}
