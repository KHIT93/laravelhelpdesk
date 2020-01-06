<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\HelpdeskTicketMessage;

class HelpdeskTicketMessageAttachment extends Model
{
    protected $guarded = [];

    public function message()
    {
        return $this->belongsTo(HelpdeskTicketMessage::class);
    }
}
