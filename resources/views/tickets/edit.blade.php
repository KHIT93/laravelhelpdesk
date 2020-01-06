@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @if (session('status'))
            <div class="card">
                <div class="card-body">
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                </div>
            </div>
            @endif
            <form method="post" action="{{ route('tickets.update', ['ticket' => $ticket->id]) }}" role="form">
                <div class="card">
                    <div class="card-header">Edit Ticket: {{$ticket->subject}}</div>
                    <div class="card-body">
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        @csrf
                        <div class="form-group">
                            <label for="helpdesk_team_id">Helpdesk Team</label>
                            <select class="form-control" id="helpdesk_team_id" required name="helpdesk_team_id">
                                @foreach($teams as $team)
                                <option value="{{$team->id}}" {{ ($ticket->helpdesk_team_id == $team->id || old('team_id') == $team->id) ? 'selected' : '' }}>{{$team->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="user_id">Assigned to</label>
                            <select class="form-control" id="user_id" required name="user_id">
                                @foreach($users as $user)
                                <option value="{{$user->id}}" {{ ($ticket->user_id == $user->id || old('user_id') == $user->id) ? 'selected' : '' }}>{{$user->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="owner">Customer</label>
                            <input type="email" class="form-control" placeholder="priority@example.com" required id="owner" name="owner" value="{{ old('owner') ?? $ticket->owner }}"/>
                        </div>
                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <input type="text" class="form-control" placeholder="Describe the issue" required id="subject" name="subject" value="{{ old('subject') ?? $ticket->subject }}"/>
                        </div>
                        <div class="form-group">
                            <label for="priority">Priority</label>
                            <select class="form-control" id="priority" required name="priority">
                                <option value="low" {{ ($ticket->priority == 'low' || old('priority') == 'low') ? 'selected' : '' }}>Low</option>
                                <option value="normal" {{ ($ticket->priority == 'normal' || old('priority') == 'normal') ? 'selected' : '' }}>Normal</option>
                                <option value="high" {{ ($ticket->priority == 'high' || old('priority') == 'high') ? 'selected' : '' }}>High</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="stage">Stage</label>
                            <select class="form-control" id="stage" required name="stage">
                                <option value="new" {{ ($ticket->stage == 'new' || old('stage') == 'new') ? 'selected' : '' }}>New</option>
                                <option value="in_progress" {{ ($ticket->stage == 'in_progress' || old('stage') == 'in_progress') ? 'selected' : '' }}>In Progress</option>
                                <option value="customer_reply" {{ ($ticket->stage == 'customer_reply' || old('stage') == 'customer_reply') ? 'selected' : '' }}>Customer Replied</option>
                                <option value="closed" {{ ($ticket->stage == 'closed' || old('stage') == 'closed') ? 'selected' : '' }}>Closed</option>
                                <option value="cancelled" {{ ($ticket->stage == 'cancelled' || old('stage') == 'cancelled') ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') ?? $ticket->description }}</textarea>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" name="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
