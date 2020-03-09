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
//            if (!$this->repository->existByName($data['name'])) // TODO: znajdz pomysl na lepsza filtracje... i czy w ogole musze filtrowac? no i jak polaczyc Brand z Category i Gear?
//            {
            $this->repository->create($data);
//            }
        }
    }
}
