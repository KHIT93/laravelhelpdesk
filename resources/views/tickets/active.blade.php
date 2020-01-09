@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if (session('status'))
            <div class="card">
                <div class="card-header">Helpdesk Tickets in progress</div>
                <div class="card-body">
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                </div>
            </div>
            @endif

            @foreach($teams as $team)
            <div class="card my-4">
                <div class="card-header">{{$team->name}}</div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Priority</th>
                                <th>Subject</th>
                                <th>From</th>
                                <th>Stage</th>
                                <th>Billing</th>
                                <th>Last Update</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($team->hasActiveTickets())
                            @foreach($team->aciveTickets() as $ticket)
                            <tr>
                                <td>{{$ticket->priority}}</td>
                                <td><a href="{{ route('tickets.show', ['ticket' => $ticket->id]) }}">{{$ticket->subject}}</a></td>
                                <td>{{$ticket->owner}}</td>
                                <td>{{$ticket->stage}}</td>
                                <td>{{$ticket->billing_type}}</td>
                                <td>{{$ticket->updated_at->diffForHumans()}}</td>
                                <td></td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="7">There are currently no tickets in progress or pending our reply</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection