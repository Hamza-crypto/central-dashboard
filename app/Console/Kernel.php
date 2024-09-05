<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('inspire')->everyMinute();
        $schedule->command('telescope:prune --hours=48')->daily();
        // $schedule->command('sync-excel')->everyMinute();
        $schedule->command('delete:unused-entries')->everyTwoHours();
        $schedule->command('analytics:fetch-hourly')->hourly();
        $schedule->command('analytics:fetch')->daily();

        $schedule->command('queue:work', [
        '--stop-when-empty'
        ])->withoutOverlapping();
        //
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
