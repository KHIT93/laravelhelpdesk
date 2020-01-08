<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\HelpdeskTicketMessage;

class HelpdeskTicketMessageAttachment extends Model
{
    protected $fillable = [
        'helpdesk_ticket_message_id',
        'name',
        'path',
        'created_at',
        'updated_at'
    ];

    public function message()
    {
        return $this->belongsTo(HelpdeskTicketMessage::class);
    }
}
