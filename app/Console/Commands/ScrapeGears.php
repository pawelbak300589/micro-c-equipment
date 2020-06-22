<?php

namespace App\Console\Commands;

use App\Scraper;
use App\Services\Scrapers\Gears\AlpinTrek;
use App\Services\Scrapers\Gears\BananaFingers;
use App\Services\Scrapers\Gears\CotswoldOutdoor;
use App\Services\Scrapers\Gears\Decathlon;
use App\Services\Scrapers\Gears\RockRun;
use App\Services\Scrapers\Gears\TrekkInn;
use App\Services\Scrapers\GearScraper;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ScrapeGears extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape:gears {--website=} {--fresh}';

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

        try
        {
            if ($this->option('fresh'))
            {
                $brandScraperOptions = ['--fresh' => true];
//            if ($this->option('website')) // TODO: this is only working when website has brand and gear scrapers, but not all scrapers has that!!!
//            {
//                $brandScraperOptions['--website'] = $this->option('website');
//            }
                $this->call('scrape:brands', $brandScraperOptions);
            }

            $newScraper = Scraper::create([
                'type' => 'gears'
            ]);

            if ($this->option('website'))
            {
                $websiteName = $this->option('website');
                $this->info('Scraping gears from website: ' . $websiteName . ' (' . Carbon::now()->toDateTimeString() . ')');

                $newScraper->update([
                    'website' => $websiteName ?? ''
                ]);

                switch ($websiteName)
                {
                    case 'AlpinTrek':
                        $scraper->scrape(new AlpinTrek);
                        break;
                    case 'BananaFingers':
                        $scraper->scrape(new BananaFingers);
                        break;
                    case 'CotswoldOutdoor':
                        $scraper->scrape(new CotswoldOutdoor);
                        break;
                    case 'Decathlon':
                        $scraper->scrape(new Decathlon);
                        break;
                    case 'RockRun':
                        $scraper->scrape(new RockRun);
                        break;
                    case 'TrekkInn':
                        $scraper->scrape(new TrekkInn);
                        break;
                    default:
                        $this->error("There is no website with name '{$websiteName}' in Database.");
                }
            }
            else
            {
                $this->info('Scraping gears from all websites in DB (' . Carbon::now()->toDateTimeString() . ').');

                $newScraper->update([
                    'website' => 'All websites'
                ]);

                $scraper->scrapeAll();
            }

            $newScraper->update([
                'ended_at' => Carbon::now()->toDateTimeString(),
            ]);

            $this->info('Scraping gears FINISHED! (' . Carbon::now()->toDateTimeString() . ')');
        } catch (Exception $e)
        {
            $newScraper->update([
                'failed_at' => Carbon::now()->toDateTimeString(),
                'errors' => $e->getMessage(),
            ]);
        }
    }
}
