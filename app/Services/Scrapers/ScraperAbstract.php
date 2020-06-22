<?php

namespace App\Services\Scrapers;

abstract class ScraperAbstract implements ScraperInterface
{
    protected $repository;

    protected $websites = [];

    public function __construct()
    {
    }

    /**
     * Scraper all data from all websites and save to DB
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
            $this->repository->create($data);
        }
    }
}
