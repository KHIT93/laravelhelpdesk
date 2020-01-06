<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\HelpdeskTicket;
use App\Models\HelpdeskTicketMessage;
use Illuminate\Support\Facades\Storage;

class TicketReply extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket;
    public $message;

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\HelpdeskTicket  $ticket
     * @param  \App\Models\HelpdeskTicketMessage  $message
     * @return void
     */
    public function __construct(HelpdeskTicket $ticket, HelpdeskTicketMessage $message)
    {
        $this->ticket = $ticket;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail = $this->from($this->ticket->team->email, $this->ticket->team->name)->subject('[' . $this->ticket->id . '] ' . $this->ticket->subject);
        if ($this->message->user)
        {
            // If email was sent by a user, check for attachments
            if ($this->message->hasAttachments())
            {
                //Append attachments to email
                foreach ($this->message->attachments as $attachment)
                {
                    $mail->attachFromStorage($attachment->path, $attachment->name);
                }
            }
        }
        return $mail->markdown('emails.ticket.reply');
    }
}
