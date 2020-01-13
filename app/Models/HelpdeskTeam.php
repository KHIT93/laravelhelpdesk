<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\HelpdeskTicket;
use App\User;

class HelpdeskTeam extends Model
{
    protected $fillable = [
        'name',
        'email',
        'email_host',
        'email_user',
        'email_pass',
        'email_encryption',
        'email_protocol'
    ];

    public function tickets()
    {
        return $this->hasMany(HelpdeskTicket::class);
    }

    public function hasTickets()
    {
        return !! $this->tickets()->count();
    }

    public function members()
    {
        return $this->hasMany(User::class);
    }

    public function pendingTickets()
    {
        return $this->tickets()->whereIn('stage',['new','customer_reply']);
    }

    public function hasPendingTickets()
    {
        return !! $this->tickets()->whereIn('stage',['new','customer_reply'])->count();
    }

    public function openTickets()
    {
        return $this->tickets()->whereIn('stage', ['new','in_progress','customer_reply']);
    }

    public function hasOpenTickets()
    {
        return !! $this->tickets()->whereIn('stage', ['new','in_progress','customer_reply'])->count();
    }

    public function closedTickets()
    {
        return $this->tickets()->whereIn('stage', ['closed', 'cancelled']);
    }

    public function hasClosedTickets()
    {
        return !! $this->tickets()->whereIn('stage', ['closed', 'cancelled'])->count();
    }

    public function activeTickets()
    {
        return $this->tickets()->whereIn('stage', ['in_progress']);
    }

    public function hasActiveTickets()
    {
        return !!$this->tickets()->whereIn('stage', ['in_progress'])->count();
    }
}
