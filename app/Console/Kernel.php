<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use File;

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
        $tracking_check_path = storage_path('logs/tracking-check/'.date('Ym/'));
        $tracking_remove_path = storage_path('logs/tracking-remove/'.date('Ym/'));
        if (!file_exists($tracking_check_path)) {
            echo "Path not found".$tracking_check_path;
            File::makeDirectory($tracking_check_path, 0755, true, true);
        }

        if (!file_exists($tracking_remove_path)) {
            File::makeDirectory($tracking_remove_path, 0755, true, true);
        }

        $schedule->command('tracking:check')
            ->everyFiveMinutes()
            ->between("05:00", "21:00")
            ->appendOutputTo($tracking_check_path.date("Ymd_H").'.log');

        $schedule->command('tracking:remove')
            ->dailyAt("06:00")
            ->appendOutputTo($tracking_remove_path.date("Ymd_H").'.log');
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
