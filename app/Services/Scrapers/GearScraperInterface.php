<?php

namespace App\Services\Scrapers;

interface GearScraperInterface
{
    public function scrapeAll();

    public function scrape(PaginatedWebsiteScraperInterface $scraper);
}
