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
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('tracking:check')
            ->everyFiveMinutes()
            ->between("05:00", "21:00")
            ->appendOutputTo(storage_path("logs/tracking/".date("Ymd_H_").'tracking_check.log'));

        $schedule->command('tracking:remove')
            ->dailyAt("06:00")
            ->appendOutputTo(storage_path("logs/tracking/".date("Ymd_H_").'tracking_remove.log'));
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
