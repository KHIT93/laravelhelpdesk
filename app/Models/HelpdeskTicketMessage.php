<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\HelpdeskTicket;
use App\Models\HelpdeskTicketMessageAttachment;
use App\User;
use DOMDocument;
use DOMXPath;

class HelpdeskTicketMessage extends Model
{
    protected $fillable = [
        'helpdesk_ticket_id',
        'user_id',
        'from',
        'message',
        'html',
        'is_note',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_note' => 'boolean',
    ];

    public function ticket()
    {
        return $this->belongsTo(HelpdeskTicket::class);
    }

    public function attachments()
    {
        return $this->hasMany(HelpdeskTicketMessageAttachment::class);
    }

    public function hasAttachments()
    {
        return !! $this->attachments()->count();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function viewHTML()
    {
        $dom = new DOMDocument();
        $dom->loadHTML($this->html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_NOERROR | LIBXML_NOWARNING);
        $xpath = new DOMXPath($dom);
        $body = $xpath->query("//body")[0]->nodeValue;
        return $body;
    }
}
