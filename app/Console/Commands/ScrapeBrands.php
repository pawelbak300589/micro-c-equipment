<?php
/**
 * php artisan scrape:brands
 * php artisan scrape:brands --fresh
 *
 * php artisan scrape:brands --website=AlpinTrek
 * php artisan scrape:brands --website=WeighMyRack
 * php artisan scrape:brands --website=RockRun
 * php artisan scrape:brands --website=TrekkInn
 * php artisan scrape:brands --website=ClimbersShop
 *
 * php artisan scrape:brands --website=AlpinTrek --fresh
 * php artisan scrape:brands --website=WeighMyRack --fresh
 * php artisan scrape:brands --website=RockRun --fresh
 * php artisan scrape:brands --website=TrekkInn --fresh
 * php artisan scrape:brands --website=ClimbersShop --fresh
 */

namespace App\Console\Commands;

use App\Services\Scrapers\Brands\AlpinTrek;
use App\Services\Scrapers\Brands\ClimbersShop;
use App\Services\Scrapers\Brands\RockRun;
use App\Services\Scrapers\Brands\TrekkInn;
use App\Services\Scrapers\Brands\WeighMyRack;
use App\Services\Scrapers\BrandScraper;
use Illuminate\Console\Command;

class ScrapeBrands extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape:brands {--website=} {--fresh}';

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
        $scraper = new BrandScraper();

        if ($this->option('fresh'))
        {
            $this->info('cleaning up DB');
            $this->call('migrate:refresh', ['--force' => true]);
            $this->info('Seed DB');
            $this->call('db:seed', ['--force' => true]);
            $this->info('DB clean up DONE!');
        }

        if ($this->option('website'))
        {
            $websiteName = $this->option('website');
            $this->info('Scraping brands from website: ' . $websiteName);
            switch ($websiteName)
            {
                case 'AlpinTrek':
                    $scraper->scrape(new AlpinTrek);
                    break;
                case 'WeighMyRack':
                    $scraper->scrape(new WeighMyRack);
                    break;
                case 'RockRun':
                    $scraper->scrape(new RockRun);
                    break;
                case 'TrekkInn':
                    $scraper->scrape(new TrekkInn);
                    break;
                case 'ClimbersShop':
                    $scraper->scrape(new ClimbersShop);
                    break;
                default:
                    $this->error("There is no website with name '{$websiteName}' in Database.");
            }
        }
        else
        {
            $this->info('Scraping brands from all websites in DB.');
            $scraper->scrapeAll();
        }
        $this->info('Scraping FINISHED!');
    }
}
