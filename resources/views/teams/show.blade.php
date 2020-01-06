@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header"><h2>{{$team->name}}</h2></div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Priority</th>
                                <th>Subject</th>
                                <th>From</th>
                                <th>Stage</th>
                                <th>Last Update</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($team->hasOpenTickets())
                            @foreach($team->openTickets() as $ticket)
                            <tr>
                                <td>{{$ticket->priority}}</td>
                                <td>{{$ticket->subject}}</td>
                                <td>{{$ticket->from}}</td>
                                <td>{{$ticket->stage}}</td>
                                <td>{{$ticket->updated_at->diffForHumans()}}</td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="5">There are currently no tickets needing attention. Good job!</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
