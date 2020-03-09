<?php

namespace App\Services\Scrapers\Brands;

use App\Services\Scrapers\WebsiteScraperInterface;
use Goutte\Client;

class RockRun implements WebsiteScraperInterface
{
    private $url = 'https://rockrun.com/collections/all-brands';
    private $crawler;

    public function __construct()
    {
        $goutteClient = new Client();
        $this->crawler = $goutteClient->request('GET', $this->url);
    }

    public function getData()
    {
        return $this->crawler->filter('div#template-collection section.section__wrapper')->each(function ($node)
        {
            $data = [];
            $websiteNames = $node->filter('div.collection__description > p a')->each(function ($field)
            {
                return $field->text();
            });
            $websiteUrls = $node->filter('div.collection__description > p a')->each(function ($field)
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
