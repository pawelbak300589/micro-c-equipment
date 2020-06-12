<?php

namespace App\Services\Scrapers\Brands;

use App\Services\Scrapers\WebsiteScraperAbstract;
use Illuminate\Support\Str;

class RockRun extends WebsiteScraperAbstract
{
    public function __construct()
    {
        $this->url = 'https://rockrun.com/collections/all-brands';
        parent::__construct();
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
                $data[$index]['url'] = $websiteUrls[$index];
                $data[$index]['website_id'] = $this->websiteId;
            }

            return $data;
        });
    }

}
