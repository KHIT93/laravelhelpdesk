@extends('layouts.app')

@section('head')

@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card mb-4">
                <div class="card-header"><strong>#{{$ticket->id}} - {{$ticket->subject}}</strong></div>
                <div class="card-body">
                    <div class="row pb-2">
                        <div class="col-md-6">
                            <div class="row py-2">
                                <div class="col-3">
                                    <span><strong>From:</strong></span>
                                </div>
                                <div class="col-9">
                                    <span>{{$ticket->owner}}</span>
                                </div>
                            </div>
                            <div class="row py-2">
                                <div class="col-3">
                                    <span><strong>Recieved:</strong></span>
                                </div>
                                <div class="col-9">
                                    <span>{{$ticket->created_at->diffForHumans()}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <form method="post" action="{{ route('tickets.update', ['ticket' => $ticket->id]) }}" role="form">
                                <input type="hidden" name="helpdesk_team_id" value="{{ $ticket->helpdesk_team_id }}" />
                                <input type="hidden" name="owner" value="{{ $ticket->owner }}" />
                                <input type="hidden" name="subject" value="{{ $ticket->subject }}" />
                                <input type="hidden" name="description" value="{{ $ticket->description }}" />
                                @csrf
                                <div class="form-row">
                                    <div class="col-3">
                                        <label class="pt-2" for="stage"><strong>Stage:</strong></label>
                                    </div>
                                    <div class="col-9">
                                        <select class="form-control" id="stage" required name="stage">
                                            <option value="new" {{ ($ticket->stage == 'new' || old('stage') == 'new') ? 'selected' : '' }}>New</option>
                                            <option value="in_progress" {{ ($ticket->stage == 'in_progress' || old('stage') == 'in_progress') ? 'selected' : '' }}>In Progress</option>
                                            <option value="customer_reply" {{ ($ticket->stage == 'customer_reply' || old('stage') == 'customer_reply') ? 'selected' : '' }}>Customer Replied</option>
                                            <option value="closed" {{ ($ticket->stage == 'closed' || old('stage') == 'closed') ? 'selected' : '' }}>Closed</option>
                                            <option value="cancelled" {{ ($ticket->stage == 'cancelled' || old('stage') == 'cancelled') ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-3">
                                        <label class="pt-2" for="priority"><strong>Priority:</strong></label>
                                    </div>
                                    <div class="col-9">
                                        <select class="form-control" id="priority" required name="priority">
                                            <option value="low" {{ ($ticket->priority == 'low' || old('priority') == 'low') ? 'selected' : '' }}>Low</option>
                                            <option value="normal" {{ ($ticket->priority == 'normal' || old('priority') == 'normal') ? 'selected' : '' }}>Normal</option>
                                            <option value="high" {{ ($ticket->priority == 'high' || old('priority') == 'high') ? 'selected' : '' }}>High</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-3">
                                        <label class="pt-2" for="user_id"><strong>Assigned To:</strong></label>
                                    </div>
                                    <div class="col-9">
                                        <select class="form-control" id="user_id" required name="user_id">
                                            @foreach($users as $user)
                                            <option value="{{$user->id}}" {{ ($ticket->user_id == $user->id || old('user_id') == $user->id) ? 'selected' : '' }}>{{$user->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </form>
                        </div>
                    </div>
                    <p class="border-top">{{$ticket->description}}</p>
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">Send a reply</div>
                <form method="post" role="form" action="{{ route('tickets.message', ['ticket' => $ticket->id]) }}" enctype="multipart/form-data">
                    <div class="card-body">
                        @csrf
                        <input type="hidden" name="from" value="{{auth()->user()->name}} <{{auth()->user()->email}}>"/>
                        <textarea class="form-control" id="message" name="message" rows="5">{{ old('message') }}</textarea>
                        <input type="file" name="attachments[]" class="form-control my-1 py-1">
                        <input type="file" name="attachments[]" class="form-control my-1 py-1">
                        <input type="file" name="attachments[]" class="form-control my-1 py-1">
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_note" id="is_note">

                                <label class="form-check-label" for="remember">
                                    {{ __('Store as a note') }}
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Send</button>
                    </div>
                </form>
            </div>

            @if($ticket->hasMessages())
            @foreach($ticket->messages as $message)
            <div class="card mb-1{{ ($message->is_note) ? ' bg-secondary text-white' : '' }}">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2 border-right">
                            <p>{{ ($message->is_note) ? 'Note' : 'Message' }}:</p>
                            <p>{{$message->from}}</p>
                            <p>{{$message->created_at->diffForHumans()}}</p>
                        </div>
                        <div class="col-md-10">
                            <div>{!! e($message->message) ?? nl2br(e($message->viewHTML())) !!}</div>
                            @if (count($message->attachments))
                            <div>
                                <ul>
                                    @foreach($message->attachments as $attachment)
                                    <li><a href="{{ route('tickets.attachment', ['ticket'=> $ticket, 'message' => $message, 'attachment' => $attachment]) }}">{{ $attachment->name }}</a></li>
                                    @endforeach
                                </ul>                            
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</div>
<script>
    
</script>
@endsection
