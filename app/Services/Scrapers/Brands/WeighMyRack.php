<?php

namespace App\Services\Scrapers\Brands;

use App\Services\Scrapers\WebsiteScraperAbstract;
use Illuminate\Support\Str;

class WeighMyRack extends WebsiteScraperAbstract
{
    public function __construct()
    {
        $this->url = 'https://blog.weighmyrack.com/who-makes-climbing-gear-we-list-all-the-climbing-brands/';
        parent::__construct();
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
                $data[$index]['url'] = $websiteUrls[$index];
                $data[$index]['website_id'] = $this->websiteId;
                $data[$index]['img'] = '/' . Str::kebab($websiteNames[$index]) . '.png';
            }

            return $data;
        });
    }
}
