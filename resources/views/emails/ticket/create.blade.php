@component('mail::message')
A ticket with reference **#{{$ticket->id}}** has been created by **{{ ($message) ? $message->from : $ticket->owner }}**:

@component('mail::panel')
**Subject**: {{ $ticket->subject }}
@endcomponent
@if($ticket->description)
@component('mail::panel')
{{ $ticket->description }}
@endcomponent
@endif
@if($message)
@component('mail::panel')
{!! ($message->message) ? e($message->message) : nl2br(e($message->viewHTML())) !!}
@endcomponent
@endif

You can reply directly to this email with a response or [view it online]({{ route('tickets.show', ['ticket' => $ticket->id]) }})
@endcomponent
