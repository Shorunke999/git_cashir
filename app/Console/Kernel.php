<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\DowntimeJob;
use Illuminate\Support\Facades\Http;
use App\Events\DowntimeEvent;

use Illuminate\Support\Str;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        //we could use platforms such as pingdom but webhook services are not free
        //use redis cache to store the data gotten from the api call and lock the action
         //$schedule->job(new DowntimeJob)->everyMinute();


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
