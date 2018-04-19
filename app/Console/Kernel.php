<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
        Commands\UpdateCaseData::class,
        Commands\UpdateCaseListing::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //
        $schedule->command('case:cron-update-data')->hourly()->withoutOverlapping()->sendOutputTo("/Library/WebServer/Documents/api/storage/logs/log.txt");
        $schedule->command('case:cron-update-listing')->hourly()->withoutOverlapping()->sendOutputTo("/Library/WebServer/Documents/api/storage/logs/listinglog.txt");
        //$schedule->command('queue:work --tries=10')->everyMinute()->withoutOverlapping()->sendOutputTo("/Library/WebServer/Documents/api/storage/logs/worklog.txt");
    }
}
