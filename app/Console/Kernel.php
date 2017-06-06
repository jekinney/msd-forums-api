<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\DropTables::class,
        Commands\CheckToSendNotification::class,
        // Commands\ThreadAuthorNotification::class,
        // Commands\ThreadNotification::class,
        // Commands\ChannelNotification::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('notifications:check')->everyFiveMinutes()->withoutOverlapping();
        // $schedule->command('notification:threadauthor')->everyTenMinutes();
        // $schedule->command('notification:threads')->weekdays()->at('23:30');
        // $schedule->command('notification:channels')->sundays('23:30');
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
