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
        Commands\NewUsers::class,
        Commands\RegisteredUsers::class,
        Commands\EndDayReport::class,
        //'App\Console\Commands\RegisteredUsers',
        //'App\Console\Commands\NewUsers',

    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('registered:users')
            ->daily();
        $schedule->command('new:users')
            ->daily();
        $schedule->command('enddayreport:users')
            ->weekly()
            ->timezone('Asia/Singapore')
            ->at('15:00');
        $schedule->command('updateuserstatus:users')
            ->daily()
            ->timezone('Asia/Singapore')
            ->at('00:10');
        $schedule->command('generaterecurringinvoice:users')
            ->daily()
            ->timezone('Asia/Singapore')
            ->at('00:20');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
