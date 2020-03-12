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

    public function scrape(WebsiteScraperInterface $scraper)
    {
        $scrapedData = $scraper->getData();

        foreach ($scrapedData as $data)
        {
            [$data['brand_id'], $data['name']] = $this->repository['gear']->transformName($data);

            $gear = $this->repository['gear']->create($data);
            if ($gear)
            {
                $data['gear_id'] = $gear->id;
                $this->repository['price']->create($this->repository['price']->convertPricesData($data));
            }
        }
    }
}
