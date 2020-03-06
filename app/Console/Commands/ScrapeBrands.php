<?php

namespace App\Console\Commands;

use App\Services\Scrapers\WebsiteScraper;
use Illuminate\Console\Command;

class ScrapeBrands extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'brands:scrape {website}';

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
        $this->argument('website');
        $scraper = new WebsiteScraper();
        $scraper->scrapeAll('brands');
    }
}
