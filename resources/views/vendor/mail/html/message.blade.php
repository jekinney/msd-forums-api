@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => 'https://msdist.com/'])
            <img src="{{ env('MAIL_LOGO') }}" alt="Mid States Distributing">
        @endcomponent
    @endslot

    {{-- Body --}}
    {{ $slot }}

    {{-- Subcopy --}}
    @if (isset($subcopy))
        @slot('subcopy')
            @component('mail::subcopy')
                {{ $subcopy }}
            @endcomponent
        @endslot
    @endif

    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            &copy; {{ date('Y') }} Mid States Distributing. All rights reserved.
        @endcomponent
    @endslot
@endcomponent
