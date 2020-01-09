<?php

namespace App\Http\Controllers;

use App\Models\HelpdeskTicket;
use App\Models\HelpdeskTeam;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\TicketReply;

class HelpdeskTicketController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tickets.index', ['tickets' => HelpdeskTicket::openTickets()->get()]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        return view('tickets.all', ['teams' => HelpdeskTeam::all()]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function closed()
    {
        return view('tickets.closed', ['teams' => HelpdeskTeam::all()]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function active()
    {
        return view('tickets.active', ['teams' => HelpdeskTeam::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tickets.create', ['teams' => HelpdeskTeam::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'helpdesk_team_id' => 'required|exists:helpdesk_teams,id',
            'owner' => 'required|email',
            'subject' => 'present',
            'description' => 'present',
            'priority' => 'present',
            'stage' => 'present'

        ]);
        $ticket = HelpdeskTicket::create($request->all());
        return redirect(route('tickets.show', ['ticket' => $ticket->id]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HelpdeskTicket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(HelpdeskTicket $ticket)
    {
        return view('tickets.show', ['ticket' => $ticket, 'users' => User::all()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HelpdeskTicket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(HelpdeskTicket $ticket)
    {
        return view('tickets.edit', ['ticket' => $ticket, 'teams' => HelpdeskTeam::all(), 'users' => User::all()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HelpdeskTicket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HelpdeskTicket $ticket)
    {
        $data = $request->validate([
            'helpdesk_team_id' => 'required|exists:helpdesk_teams,id',
            'owner' => 'required|email',
            'subject' => 'present',
            'description' => 'present',
            'priority' => 'present',
            'stage' => 'present',
            'user_id' => 'present'
        ]);
        $ticket->update($request->all());
        return redirect(route('tickets.show', ['ticket' => $ticket->id]));
    }

    /**
     * Send a message to the owner of the ticket.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HelpdeskTicket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function message(Request $request, HelpdeskTicket $ticket)
    {
        $data = $request->validate(['message' => 'required', 'from' => 'required', 'is_note' => 'boolean']);
        $data['user_id'] = Auth::id();
        $data['is_note'] = $request->is_note;
        
        $message = $ticket->messages()->create($data);
        if ($request->hasFile('attachments'))
        {
            foreach ($request->attachments as $attachment)
            {
                $path = $attachment->store('tickets/' . $ticket->id);
                $message->attachments()->create([
                    'name' => $attachment->getClientOriginalName(),
                    'path' => $path
                ]);
            }
        }
        if (!$request->is_note)
        {
            Mail::to($ticket->owner)->send(new TicketReply($ticket, $message));
        }
        return redirect(route('tickets.show', ['ticket' => $ticket->id]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HelpdeskTicket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(HelpdeskTicket $ticket)
    {
        //
    }
}
