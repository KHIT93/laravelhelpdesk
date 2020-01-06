<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\HelpdeskTeam;
use App\Models\HelpdeskTicket;
use App\Models\HelpdeskTicketMessage;
use App\User;
use App\Mail\TicketCreated;
use App\Mail\TicketReply;
use App\Mail\TicketReceived;
use Webklex\IMAP\Client;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;

class RecieveMessagesFromMailbox
{
    use Dispatchable, Queueable;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach (HelpdeskTeam::all() as $team)
        {
            $options = [
                'host' => $team->email_host,
                'username' => $team->email_user,
                'password' => $team->email_pass,
                'protocol' => $team->email_protocol,
                'validate_cert' => 0
            ];
            // $options = ['host' => 'fra1-01.khansen-it.dk', 'port' => 993, 'encryption' => 'ssl', 'validate_cert' => false, 'username' => 'helpdesk@mailtest.khansen.tech','password'=>'Test1234!','protocol'=>'imap'];
            $emailPort = false;
            if ($team->email_encryption == 'none' || $team->email_encryption == 'starttls')
            {
                $options['port'] = ($team->email_protocol == 'imap') ? 143 : 110;
                $options['encryption'] = $team->email_encryption == 'starttls' ? 'starttls' : false;
            }
            if ($team->email_encryption == 'ssl')
            {
                $options['port'] = ($team->email_protocol == 'imap') ? 993 : 995;
                $options['encryption'] = 'ssl';
            }
            print_r($options);
            $client = new Client($options);
            // Connect the client
            if ($client->connect())
            {
                echo 'Connection to server is succesful' . chr(10);
                $inbox = $client->getFolder('INBOX');
                // foreach ($inbox->query()->unseen()->get() as $message)
                foreach ($inbox->messages()->all()->get() as $message)
                {
                    echo 'Processing message: ' . $message->getSubject() . '' . chr(10);
                    $match = false;
                    $new = false;
                    $matches = [];
                    preg_match('/\[\d*\]/m', $message->getSubject(), $matches);
                    if (count($matches))
                    {
                        $match = $matches[0];
                    }

                    $ticket = HelpdeskTicket::whereId((int)str_replace(']','',str_replace('[','',$match)))->first();

                    if (!$ticket)
                    {
                        echo 'Ticket does not already exist. Creating it now' . chr(10);
                        $ticket = $team->tickets()->create(
                            [
                                'owner' => $message->getFrom()[0]->mail,
                                'subject' => $message->getSubject(),
                                'created_at' => $message->getDate(),
                                'updated_at' => \Carbon\Carbon::now()
                            ]
                        );
                        $new = true;
                        Mail::to($ticket->owner)->send(new TicketReceived($ticket));
                    }
                    else
                    {
                        echo 'Ticket does already exist. Appending new message';
                        $ticket->stage = 'customer_reply';
                        $ticket->save();
                    }
                    
                    $ticketMessage = $ticket->messages()->create([
                        'from' => $message->getFrom()[0]->full,
                        'message' => ($message->hasTextBody()) ? $message->getTextBody() : null,
                        'html' => ($message->hasHTMLBody()) ? $message->getHTMLBody() : null,
                        'created_at' => $message->getDate(),
                        'updated_at' => \Carbon\Carbon::now()
                    ]);
                    if ($message->hasAttachments())
                    {
                        // Make sure that a directory exists for storing the attachments for this ticket message
                        if(!Storage::exists('tickets/' . $ticket->id))
                        {
                            Storage::makeDirectory('tickets/' . $ticket->id);
                        }
                        $message->getAttachments()->each(function($attachment){
                            $attachment->save(storage_path('tickets/' . $ticket->id));
                            $ticketMessage->attachments->create([
                                'path' => 'tickets/' . $ticket->id . '/' . $attachment->getName(),
                                'name' => $attachment->getName()
                            ]);
                        });
                    }
                    $message->setFlag('Seen');
                    // $message->markAsRead();
                    if ($new)
                    {
                        Mail::to(User::all())->send(new TicketCreated($ticket, $ticketMessage));
                    }
                    else
                    {
                        $recipients = [];
                        if ($ticket->user)
                        {
                            $recipients = collect($ticket->user->email);
                        }
                        else
                        {
                            $recipients = User::all();
                        }
                        Mail::to($recipients)->send(new TicketReply($ticket, $ticketMessage));
                    }
                    if ($message->moveToFolder('Read') == true)
                    {
                        echo 'Message moved succesfully to archive' . chr(10);
                    }
                    else
                    {
                        echo 'Message not moved to archive' . chr(10);
                    }
                    sleep(5);
                }
                $client->disconnect();
            }   
            else
            {
                foreach ($client-getErrors() as $error)
                {
                    echo $error;
                }
            }
        }
    }
}
