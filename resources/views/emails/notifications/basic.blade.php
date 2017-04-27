@component('mail::message')
Dear {{ $recipient->name }},<br>

{!! $notification->message !!}


Thank You,<br>
Mid States Distributing
@endcomponent
