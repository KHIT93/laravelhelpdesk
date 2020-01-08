<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\HelpdeskTeam;
use App\Models\HelpdeskTicketMessage;
use App\User;

class HelpdeskTicket extends Model
{
    protected $fillable = [
        'helpdesk_team_id',
        'user_id',
        'owner',
        'priority',
        'stage',
        'subject',
        'description',
        'created_at',
        'updated_at'
    ];

    public function team()
    {
        return $this->belongsTo(HelpdeskTeam::class, 'helpdesk_team_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function messages()
    {
        return $this->hasMany(HelpdeskTicketMessage::class);
    }

    public function hasMessages()
    {
        return !! $this->messages()->count();
    }

    public function isOpen()
    {
        return in_array($this->stage, ['new','customer_reply','in_progress']);
    }

    public function isPending()
    {
        return in_array($this->stage, ['new','customer_reply']);
    }
    
    public function scopeOpenTickets($query)
    {
        return $query->whereIn('stage', ['new', 'customer_reply', 'in_progress']);
    }
    public function scopePendingTickets($query)
    {
        return $query->whereIn('stage', ['new', 'customer_reply']);
    }
}
