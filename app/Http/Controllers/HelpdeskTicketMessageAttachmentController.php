<?php

namespace App\Http\Controllers;

use App\Models\HelpdeskTicket;
use App\Models\HelpdeskTicketMessage;
use App\Models\HelpdeskTicketMessageAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HelpdeskTicketMessageAttachmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HelpdeskTicket  $ticket
     * @param  \App\Models\HelpdeskTicketMessage  $message
     * @param  \App\Models\HelpdeskTicketMessageAttachments  $attachment
     * @return \Illuminate\Http\Response
     */
    public function show(HelpdeskTicket $ticket, HelpdeskTicketMessage $message, HelpdeskTicketMessageAttachment $attachment)
    {
        return Storage::download($attachment->path, $attachment->name);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HelpdeskTicketMessageAttachments  $helpdeskTicketMessageAttachments
     * @return \Illuminate\Http\Response
     */
    public function edit(HelpdeskTicketMessageAttachments $helpdeskTicketMessageAttachments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HelpdeskTicketMessageAttachments  $helpdeskTicketMessageAttachments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HelpdeskTicketMessageAttachments $helpdeskTicketMessageAttachments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HelpdeskTicketMessageAttachments  $helpdeskTicketMessageAttachments
     * @return \Illuminate\Http\Response
     */
    public function destroy(HelpdeskTicketMessageAttachments $helpdeskTicketMessageAttachments)
    {
        //
    }
}
