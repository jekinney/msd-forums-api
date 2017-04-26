<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Notifications\ProcessNotification' => [
            'App\Listeners\Notifications\SendTexts',
            'App\Listeners\Notifications\SendEmails',
        ],

        'App\Events\Notifications\TextSent' => [
            'App\Listeners\Notifications\SetTextStatus',
        ],

        'App\Events\Notifications\TextReceipt' => [
            'App\Listeners\Notifications\ProcessTextReceipt',
        ],

        'App\Events\Notifications\EmailSent '=> [
            'App\Listeners\Notifications\SetEmailStatus',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
