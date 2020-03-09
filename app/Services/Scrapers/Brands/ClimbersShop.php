<?php

namespace App\Services\Scrapers\Brands;

use App\Services\Scrapers\WebsiteScraperAbstract;

class ClimbersShop extends WebsiteScraperAbstract
{
    public function __construct()
    {
        $this->url = 'https://www.climbers-shop.com/pages/brands/';
        parent::__construct();
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
                $data[$index]['url'] = $websiteUrls[$index];
                $data[$index]['website'] = 'ClimbersShop';
            }

            return $data;
        });
    }

}
