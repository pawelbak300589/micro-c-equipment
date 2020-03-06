<?php
/**
 * WebsiteScraper file
 *
 */

namespace App\Services\Scrapers;

/**
 * Class WebsiteScraper
 * @package App\Services
 */
class WebsiteScraper
{
    public function scrapeAll($type = 'brands')
    {
        $methodName = 'scrape' . ucfirst($type);
        $this->$methodName();
    }

    private function scrapeBrands()
    {

    }

    private function scrapeCategories()
    {

    }

    private function scrapeGears()
    {

    }

}
