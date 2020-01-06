<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\HelpdeskTicket;
use App\Models\HelpdeskTicketMessage;

class TicketCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket;
    public $message;

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\HelpdeskTicket  $ticket
     * @return void
     */
    public function __construct(HelpdeskTicket $ticket, HelpdeskTicketMessage $message = null)
    {
        $this->ticket = $ticket;
        if ($message)
        {
            $this->message = $message;
        }
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->ticket->team->email)->subject('[' . $this->ticket->id . '] ' . $this->ticket->subject)->markdown('emails.ticket.create');
    }
}
