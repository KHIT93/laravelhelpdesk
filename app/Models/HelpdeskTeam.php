<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\HelpdeskTicket;
use App\User;

class HelpdeskTeam extends Model
{
    protected $guarded = [];

    public function tickets()
    {
        return $this->hasMany(HelpdeskTicket::class);
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
}
