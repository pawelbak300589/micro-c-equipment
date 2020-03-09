<?php

namespace App\Services\Scrapers\Categories;

use App\Services\Scrapers\WebsiteScraperAbstract;

class TrekkInn extends WebsiteScraperAbstract
{
    public function __construct()
    {
        $this->url = 'https://www.trekkinn.com/outdoor-mountain/climbing-equipment/11243/f';
        parent::__construct();
    }

    public function getData()
    {
        return $this->crawler->filter('div#parallax div.listado_familias')->each(function ($node)
        {
            $data = [];
            $websiteNames = $node->filter('li div.bloque p a')->each(function ($field)
            {
                return $field->text();
            });
            $websiteUrls = $node->filter('li div.bloque p a')->each(function ($field)
            {
                return $field->attr('href');
            });

            foreach ($websiteNames as $index => $name)
            {
                if ($name !== '')
                {
                    $data[$index]['name'] = $websiteNames[$index];
                    $data[$index]['url'] = $websiteUrls[$index];
                    $data[$index]['website'] = 'TrekkInn';
                }
            }

            return $data;
        });
    }

}
