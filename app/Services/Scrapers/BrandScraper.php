<?php
/**
 *  BrandScraper file
 */

namespace App\Services\Scrapers;

use App\Brand;
use App\Repositories\BrandRepository;
use App\Services\Scrapers\Brands\RockRun;
use App\Services\Scrapers\Brands\WeighMyRack;
use App\Services\Scrapers\Brands\ClimbersShop;

/**
 * Class BrandScraper
 * @package App\Services\Scrapers
 */
class BrandScraper implements ScraperInterface
{
    private $repository;

    protected $websites = [
        WeighMyRack::class,
        RockRun::class,
//        ClimbersShop::class,
    ];

    public function __construct()
    {
        $this->repository = new BrandRepository(new Brand());
    }

    /**
     * Scrape all data from all websites and save to DB
     */
    public function scrapeAll()
    {
        foreach ($this->websites as $websiteClassName)
        {
            $this->scrape(new $websiteClassName);
        }
    }

    public function scrape(WebsiteScraperInterface $scraper)
    {
        $scrapedData = $scraper->getData()[0];

        foreach ($scrapedData as $data)
        {
            if (!$this->repository->existByName($data['name']))
            {
                $this->repository->create($data);
            }
        }
    }
}
