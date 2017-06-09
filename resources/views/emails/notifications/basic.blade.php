@component('mail::message')
Dear {{ $recipient->name }},<br>

{!! $email->message !!}

Thank You,<br>
Mid-States Distributing
@endcomponent
