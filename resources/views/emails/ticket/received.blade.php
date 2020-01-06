@component('mail::message')
Your email has been received

Thank you for contacting our support.
We hereby acknowledge to have received your email and it has been assigned ticket reference **#{{$ticket->id}}**

Should you have any further comments to add to your ticket, please reply directly to this email.

When replying, please leave the message contents, subject and recipient untouched.

**Best regards**,

{{$ticket->team->name}}
@endcomponent
