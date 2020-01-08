@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if (session('status'))
            <div class="card">
                <div class="card-body">
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                </div>
            </div>
            @endif
            <div class="card">
                <div class="card-header">Manage Helpdesk Tickets</div>
                <div class="card-body">
                    <a href="{{ route('tickets.create') }}" class="btn btn-primary mb-3">Create ticket</a>
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
                            @if($tickets->count())
                            @foreach($tickets as $ticket)
                            <tr>
                                <td>{{$ticket->priority}}</td>
                                <td><a href="{{ route('tickets.show', ['ticket' => $ticket->id]) }}">{{$ticket->subject}}</a></td>
                                <td>{{$ticket->owner}}</td>
                                <td>{{$ticket->stage}}</td>
                                <td>{{$ticket->billing_type}}</td>
                                <td>{{$ticket->updated_at->diffForHumans()}}</td>
                                <td><a href="{{ route('tickets.edit',['ticket'=>$ticket->id]) }}" class="btn btn-sm btn-primary">Edit</a>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="6">There are currently no open tickets!</td>
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
