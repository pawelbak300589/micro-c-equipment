<?php

namespace App\Services\Scrapers\Categories;

use App\Services\Scrapers\WebsiteScraperAbstract;

class AlpinTrek extends WebsiteScraperAbstract
{
    public function __construct()
    {
        $this->url = 'https://www.alpinetrek.co.uk/climbing/';
        parent::__construct();
    }

    public function getData()
    {
        return $this->crawler->filter('div#list')->each(function ($node)
        {
            $data = [];
            $globalIndex = 0;
            $websiteMainNames = $node->filter('a.cat-title-link div.cat-title')->each(function ($field)
            {
                return $field->text();
            });
            $websiteMainUrls = $node->filter('a.cat-title-link')->each(function ($field)
            {
                return $field->attr('href');
            });

            foreach ($websiteMainNames as $index => $name)
            {
                $data[$globalIndex]['name'] = $websiteMainNames[$index];
                $data[$globalIndex]['url'] = $websiteMainUrls[$index];
                $data[$globalIndex]['website_id'] = $this->websiteId;
                $globalIndex++;
            }

            $websiteNames = $node->filter('li.subcat a')->each(function ($field)
            {
                return $field->text();
            });
            $websiteUrls = $node->filter('li.subcat a')->each(function ($field)
            {
                return $field->attr('href');
            });

            foreach ($websiteNames as $index => $name)
            {
                $data[$globalIndex]['name'] = $websiteNames[$index];
                $data[$globalIndex]['url'] = $websiteUrls[$index];
                $data[$globalIndex]['website_id'] = $this->websiteId;
                $globalIndex++;
            }

            return $data;
        });
    }

}
