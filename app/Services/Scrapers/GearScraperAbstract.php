<?php

namespace App\Services\Scrapers;

abstract class GearScraperAbstract implements GearScraperInterface
{
    protected $repository;

    protected $websites = [];

    public function __construct()
    {
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

    public function scrape(PaginatedWebsiteScraperInterface $scraper)
    {
        $scrapedData = $scraper->getData()[0];

        foreach ($scrapedData as $data)
        {
            // TODO: filter data before saveing to avoid duplication for the same product on the same website - if price did not change keep old price etc.

            // Deal collection in for example RockRun can duplicate products, because they are visible in other collections too.
            // e.g. Carabiners are in the carabiners category, but some carabiners can be visible as a deal too.
            // Do checks if product exist in DB and if exists just add price (if different than last added price).

            dd($data);

//            if (!$this->repository->existByName($data['name']))
//            {
            $this->repository->create($data);
//            }
        }
    }
}
