<?php

namespace App\Services\Scrapers\Brands;

use App\Services\Scrapers\WebsiteScraperInterface;
use Goutte\Client;

class ClimbersShop implements WebsiteScraperInterface
{
    private $url = 'https://www.climbers-shop.com/pages/brands/';
    private $crawler;

    public function __construct()
    {
        $goutteClient = new Client();
        $this->crawler = $goutteClient->request('GET', $this->url);
    }

    public function getData()
    {
        return $this->crawler->filter('div.col-1.innerContainer')->each(function ($node)
        {
            $data = [];
            $websiteNames = $node->filter('div.brandLanding a div.brandPageLink')->each(function ($field)
            {
                return $field->text();
            });
            $websiteUrls = $node->filter('div.brandLanding a')->each(function ($field)
            {
                return $field->attr('href');
            });

            foreach ($websiteNames as $index => $name)
            {
                $data[$index]['name'] = $websiteNames[$index];
                $data[$index]['website'] = $websiteUrls[$index];
            }

            return $data;
        });
    }

}
