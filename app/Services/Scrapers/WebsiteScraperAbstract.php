<?php

namespace App\Services\Scrapers;

use Goutte\Client;

abstract class WebsiteScraperAbstract implements WebsiteScraperInterface
{
    protected $url;
    protected $crawler;

    public function __construct()
    {
        $goutteClient = new Client();
        $this->crawler = $goutteClient->request('GET', $this->url);
    }
}
