<?php

namespace App\Services\Scrapers\Brands;

use App\Services\Scrapers\WebsiteScraperAbstract;

class AlpinTrek extends WebsiteScraperAbstract
{
    public function __construct()
    {
        $this->url = 'https://www.alpinetrek.co.uk/brands/';
        parent::__construct();
    }

    public function getData()
    {
        return $this->crawler->filter('div#list_manufacturer')->each(function ($node)
        {
            $data = [];
            $websiteNames = $node->filter('li.manufacturer-listitem div.manufacturer div.title a')->each(function ($field)
            {
                return $field->text();
            });
            $websiteUrls = $node->filter('li.manufacturer-listitem div.manufacturer div.title a')->each(function ($field)
            {
                return $field->attr('href');
            });

            foreach ($websiteNames as $index => $name)
            {
                $data[$index]['name'] = $websiteNames[$index];
                $data[$index]['url'] = $websiteUrls[$index];
                $data[$index]['website_id'] = $this->websiteId;
            }

            return $data;
        });
    }

}
