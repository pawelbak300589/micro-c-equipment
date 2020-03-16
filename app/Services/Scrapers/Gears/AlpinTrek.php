<?php
/**
 * AlpinTrek Website Scraper file
 */

namespace App\Services\Scrapers\Gears;

use App\Services\Scrapers\PaginatedWebsiteScraperAbstract;

/**
 * AlpinTrek Website Scraper class
 * @package App\Services\Scrapers\Gears
 */
class AlpinTrek extends PaginatedWebsiteScraperAbstract
{
    public function __construct()
    {
        $this->collections = config('collections.websites.AlpinTrek');
        parent::__construct();
    }

    public function getData()
    {
        for ($collectionIndex = 0; $collectionIndex < $this->getCollectionsNumber(); $collectionIndex++)
        {
            foreach ($this->crawlers[$collectionIndex] as $crawler)
            {
                $productsLinks = $crawler->filter('ul#product-list li.product-item a.product-link')->each(function ($field)
                {
                    $links['url'] = $field->attr('href');
                    return $links;
                });

                $productsInfos = $crawler->filter('ul#product-list li.product-item a.product-link div.product-infobox')->each(function ($field)
                {
                    $infos['brand'] = $field->filter('div.manufacturer-title')->count() ? $field->filter('div.manufacturer-title')->text() : '';
                    $infos['name'] = $field->filter('div.product-title')->count() ? $field->filter('div.product-title')->text() : '';
                    return $infos;
                });

                $productsPrices = $crawler->filter('ul#product-list li.product-item a.product-link div.product-price')->each(function ($field)
                {
                    $price = $field->filter('span.price')->text();

                    if (strpos($price, 'from '))
                    {
                        $prices['prices'][] = 'from';
                    }
                    $prices['prices'][] = str_replace(array('from', ' '), '', $price);
                    if ($field->filter('span.uvp')->count())
                    {
                        $isSale = true;
                        $prices['prices'][] = str_replace(' ', '', $field->filter('span.uvp')->text());
                    }

                    $prices['type'] = $this->setPriceType($prices['prices'], $isSale ?? false);
                    $prices['website_id'] = $this->websiteId;
                    return $prices;
                });

                for ($i = 0, $iMax = count($productsLinks); $i < $iMax; $i++)
                {
                    $data[] = array_merge($productsLinks[$i], $productsInfos[$i], $productsPrices[$i]);
                }
            }
        }

        return $data;
    }

    public function updatePagesNumber()
    {
        for ($collectionIndex = 0; $collectionIndex < $this->getCollectionsNumber(); $collectionIndex++)
        {
            $paginator = $this->crawlers[$collectionIndex][1]->filter('div.paging');
            $this->pages[$collectionIndex] = $paginator->count() ? $this->crawlers[$collectionIndex][1]
                ->filter('div.paging a.locator-item')
                ->last()->text() : 1;
        }
    }

    /**
     * TODO: maybe we can use some cache here to speed up scraping process (https://laravel.com/docs/6.x/cache) - set crawlers to cache so doesnt need to set it up every time you run scrape:gears - set cache for a week, because website can change after a week.
     */
    public function setCrawlers()
    {
        foreach ($this->collections as $collectionIndex => $collectionUrl)
        {
            for ($pageNum = 1; $pageNum <= $this->pages[$collectionIndex]; $pageNum++)
            {
                $this->crawlers[$collectionIndex][$pageNum] = $this->goutteClient->request('GET', $collectionUrl . '/' . $pageNum . '/');
            }
        }
    }
}
