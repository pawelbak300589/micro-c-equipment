<?php

namespace App\Console;

use App\Console\Commands\ScrapeBrands;
use App\Console\Commands\ScrapeCategories;
use App\Console\Commands\ScrapeGears;
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
        ScrapeBrands::class,
        ScrapeCategories::class,
        ScrapeGears::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
//        $schedule->command('scrape:brands')->monthly(); // TODO: set some checks to not duplicate brands before you'll use it as a crone job
//        $schedule->command('scrape:categories')->weekly(); // TODO: set some checks to not duplicate categories before you'll use it as a crone job
//        $schedule->command('scrape:gears')->weekly(); // TODO: set some checks to not duplicate gears before you'll use it as a crone job
    }
}
