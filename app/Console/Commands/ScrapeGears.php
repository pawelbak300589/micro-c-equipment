<?php

namespace App\Console\Commands;

use App\Services\Scrapers\GearScraper;
use Illuminate\Console\Command;

class ScrapeGears extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape:gears {--website=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape brands from website and save it to DB table';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $scraper = new GearScraper();
        $scraper->scrapeAll();
    }
}
