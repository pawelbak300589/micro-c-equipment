<?php
/**
 * TrekkInn Website Scraper file
 */

namespace App\Services\Scrapers\Gears;

use App\Services\Scrapers\PaginatedWebsiteScraperAbstract;

/**
 * TrekkInn Website Scraper class
 * @package App\Services\Scrapers\Gears
 */
class TrekkInn extends PaginatedWebsiteScraperAbstract
{
    public function __construct()
    {
        $this->collections = config('collections.websites.TrekkInn');
        parent::__construct();
    }

    public function getData()
    {
        for ($collectionIndex = 0; $collectionIndex < $this->getCollectionsNumber(); $collectionIndex++)
        {
            foreach ($this->crawlers[$collectionIndex] as $crawler)
            {
                $productsLinks = $crawler->filter('div.nuestra_seleccion ul li div.BoxPrice p.BoxPriceName a')->each(function ($field)
                {
                    $link['name'] = $field->text();
                    $link['url'] = $field->attr('href');
                    return $link;
                });

                $productsPrices = $crawler->filter('div.nuestra_seleccion ul li div.BoxPrice p.BoxPriceValor')->each(function ($field)
                {
                    $price['prices'] = $field->text() !== 'Sold Out' ? explode(' ', str_replace('£ ', '£', $field->text())) : [$field->text()];
                    $isSale = in_array('sale', explode(' ', $field->attr('class')), true);
                    $price['type'] = $this->setPriceType($price['prices'], $isSale);
                    $price['website_id'] = $this->websiteId;
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

    /**
     * TODO: maybe we can use some cache here to speed up scraping process (https://laravel.com/docs/6.x/cache) - set crawlers to cache so doesnt need to set it up every time you run scrape:gears - set cache for a week, because website can change after a week.
     */
    public function setCrawlers()
    {
        foreach ($this->collections as $collectionIndex => $collectionUrl)
        {
            for ($pageNum = 1; $pageNum <= $this->pages[$collectionIndex]; $pageNum++)
            {
                $this->crawlers[$collectionIndex][$pageNum] = $this->goutteClient->request('GET', $collectionUrl);
//                $this->crawlers[$collectionIndex][$pageNum] = $this->goutteClient->request('GET', $collectionUrl . '?page=' . $pageNum);
            }
        }
    }
}
