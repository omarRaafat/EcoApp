<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command("transactions:cancel-unpaid-for-ten-minutes")->everyFifteenMinutes()->withoutOverlapping()->between('6:00', '23:59');
        $schedule->command("statistics:store")->dailyAt("03:00")->withoutOverlapping();
        $schedule->command("product:sales")->dailyAt("00:00")->withoutOverlapping();
        $schedule->command('generate:sitemap')->daily()->withoutOverlapping();
        $schedule->command("command:UpdateOrdersAramexCommand")->everyTwoHours()->withoutOverlapping();
        $schedule->command("vendorWallet:updateTransactionStatus")->dailyAt("00:00")->withoutOverlapping();
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
