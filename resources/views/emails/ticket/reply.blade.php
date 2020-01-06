@component('mail::message')
A new reply has been posted on ticket **#{{$ticket->id}}** by **{{ ($message->user_id) ? $message->user->name : $message->from }}**:

@component('mail::panel')
{{ $message->message }}
@endcomponent

When replying, please leave the message contents, subject and recipient untouched.
@endcomponent