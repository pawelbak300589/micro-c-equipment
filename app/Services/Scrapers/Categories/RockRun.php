<?php

namespace App\Services\Scrapers\Categories;

use App\Services\Scrapers\WebsiteScraperAbstract;

class RockRun extends WebsiteScraperAbstract
{
    public function __construct()
    {
        $this->url = 'https://rockrun.com/pages/climbing-equipment';
        parent::__construct();
    }

    public function getData()
    {
        return $this->crawler->filter('main#template-page div.page__content')->each(function ($node)
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

            foreach ($websiteNames as $index => $name)
            {
                $data[$index]['name'] = $websiteNames[$index];
                $data[$index]['url'] = $websiteUrls[$index];
                $data[$index]['website'] = 'RockRun';
            }

            return $data;
        });
    }
}
