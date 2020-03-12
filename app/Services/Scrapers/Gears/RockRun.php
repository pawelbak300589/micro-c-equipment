<?php

namespace App\Services\Scrapers\Gears;

use App\Services\Scrapers\PaginatedWebsiteScraperAbstract;

class RockRun extends PaginatedWebsiteScraperAbstract
{
    public function __construct()
    {
        $this->collections = config('collections.websites.RockRun');
        parent::__construct();
    }

    public function getData()
    {
        for ($collectionIndex = 0; $collectionIndex < $this->getCollectionsNumber(); $collectionIndex++)
        {
            foreach ($this->crawlers[$collectionIndex] as $crawler)
            {
                $productsLinks = $crawler->filter('div#template-collection div.collection-matrix a.product-thumbnail__title')->each(function ($field)
                {
                    $link['name'] = $field->text();
                    $link['url'] = $field->attr('href');
                    $link['website_id'] = $this->websiteId;
                    return $link;
                });

                $productsPrices = $crawler->filter('div#template-collection div.collection-matrix span.product-thumbnail__price')->each(function ($field)
                {
                    $price['prices'] = $field->text() !== 'Sold Out' ? explode(' ', $field->text()) : $field->text();
                    $price['prices_type'] = 'normal';
                    $isSale = in_array('sale', explode(' ', $field->attr('class')), true);
                    if ($isSale)
                    {
                        $price['prices_type'] = 'sale';
                        if ($price['prices'] === 'Sold Out')
                        {
                            $price['prices_type'] = 'sold';
                        }
                    }
                    return $price;
                });

                for ($i = 0, $iMax = count($productsLinks); $i < $iMax; $i++)
                {
                    $data[] = array_merge($productsLinks[$i], $productsPrices[$i]);
                }
            }
        }

        return $data;
    }

    public function updatePagesNumber()
    {
        for ($collectionIndex = 0; $collectionIndex < $this->getCollectionsNumber(); $collectionIndex++)
        {
            $paginator = $this->crawlers[$collectionIndex][1]->filter('div.container--pagination div.paginate');
            $this->pages[$collectionIndex] = $paginator->count() ? $this->crawlers[$collectionIndex][1]
                ->filter('div.container--pagination div.paginate')
                ->attr('data-paginate-pages') : 1;
        }
    }

    public function setCrawlers()
    {
        foreach ($this->collections as $collectionIndex => $collectionUrl)
        {
            for ($pageNum = 1; $pageNum <= $this->pages[$collectionIndex]; $pageNum++)
            {
                $this->crawlers[$collectionIndex][$pageNum] = $this->goutteClient->request('GET', $collectionUrl . '?page=' . $pageNum);
            }
        }
    }
}
