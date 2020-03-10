<?php

namespace App\Services\Scrapers;

use App\Website;
use Goutte\Client;
use ReflectionClass;

abstract class WebsiteScraperAbstract implements WebsiteScraperInterface
{
    protected $websiteId;
    protected $url;
    protected $crawler;

    public function __construct()
    {
        $goutteClient = new Client();
        $this->crawler = $goutteClient->request('GET', $this->url);
        $this->prepareWebsiteId();
    }

    /**
     * Prepare website ID for website scraping data
     * (Website scraping name must be the same as website name in DB)
     *
     * @return void
     */
    private function prepareWebsiteId(): void
    {
        try
        {
            $this->websiteId = Website::where('name', (new ReflectionClass($this))->getShortName())->first()->id;
        } catch (\ReflectionException $e)
        {
            dd($e->getMessage());
        }
    }
}
