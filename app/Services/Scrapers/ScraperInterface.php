<?php

namespace App\Services\Scrapers;

interface ScraperInterface
{
    public function scrapeAll();

    public function scrape(WebsiteScraperInterface $scraper);
}
