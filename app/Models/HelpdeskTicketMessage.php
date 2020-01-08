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
    protected $guarded = [];

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
        libxml_use_internal_errors(false);
        $dom = new DOMDocument();
        $dom->loadHTML($this->html);
        $xpath = new DOMXPath($dom);
        $body = $xpath->query("//body")[0]->nodeValue;
        return $body;
    }
}
