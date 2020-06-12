<?php

namespace App\Services\Scrapers\Brands;

use App\Services\Scrapers\WebsiteScraperAbstract;
use Illuminate\Support\Str;

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
            $websiteImages = $node->filter('li.manufacturer-listitem a.img img')->each(function ($field)
            {
                return $field->attr('data-src');
            });

            foreach ($websiteNames as $index => $name)
            {
                $data[$index]['name'] = $websiteNames[$index];
                $data[$index]['url'] = $websiteUrls[$index];
                $data[$index]['website_id'] = $this->websiteId;
                $data[$index]['img'] = $this->modifyImageUrl($websiteImages[$index]);
            }

            return $data;
        });
    }

    public function modifyImageUrl($imageUrl)
    {
        return str_replace(['80_60_90', '(1)', '(2)', '(3)', '(4)'], ['200_150_90', '', '', '', ''], $imageUrl);
    }

}
