<?php

namespace App\Services\Scrapers\Brands;

use App\Services\Scrapers\WebsiteScraperInterface;
use Goutte\Client;

class WeighMyRack implements WebsiteScraperInterface
{
    private $url = 'https://blog.weighmyrack.com/who-makes-climbing-gear-we-list-all-the-climbing-brands/';
    private $crawler;

    public function __construct()
    {
        $goutteClient = new Client();
        $this->crawler = $goutteClient->request('GET', $this->url);
    }

    public function getData()
    {
        return $this->crawler->filter('div#content_wrapper div.post_inner_wrapper')->each(function ($node)
        {
            $data = [];
            $websiteNames = $node->filter('p a')->each(function ($field)
            {
                return $field->text();
            });
            $websiteUrls = $node->filter('p a')->each(function ($field)
            {
                return $field->attr('href');
            });
//            $websiteDescriptions = $node->filter('p')->each(function ($field)
//            {
//                return $field->text();
//            });

            foreach ($websiteNames as $index => $name)
            {
                $data[$index]['name'] = $websiteNames[$index];
                $data[$index]['website'] = $websiteUrls[$index];
            }

            return $data;
        });
    }
}
