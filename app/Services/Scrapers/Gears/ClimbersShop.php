<?php
/**
 * ClimbersShop Website Scraper file
 */

namespace App\Services\Scrapers\Gears;

use App\Services\Scrapers\PaginatedWebsiteScraperAbstract;

/**
 * ClimbersShop Website Scraper class
 * @package App\Services\Scrapers\Gears
 */
class ClimbersShop extends PaginatedWebsiteScraperAbstract
{
    public function __construct()
    {
        $this->collections = config('collections.websites.ClimbersShop');
        parent::__construct();
    }

    public function getData()
    {
        for ($collectionIndex = 0; $collectionIndex < $this->getCollectionsNumber(); $collectionIndex++)
        {
            foreach ($this->crawlers[$collectionIndex] as $crawler)
            {
                dd($crawler->filter('div.productContainer div.item')->count());

                $productsLinks = $crawler->filter('div.productContainer div.item div.facetItemDetails a.frItemName')->each(function ($field)
                {
                    $link['name'] = $field->text();
                    $link['url'] = $field->attr('href');
                    return $link;
                });

                dd($productsLinks);

                $productsPrices = $crawler->filter('div.productContainer div.facetItemDetails div.facetPricing div.pricing')->each(function ($field)
                {
                    $price['prices'] = $field->text() !== 'Sold Out' ? explode(' ', $field->text()) : [$field->text()];
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

//    public function updatePagesNumber()
//    {
//        for ($collectionIndex = 0; $collectionIndex < $this->getCollectionsNumber(); $collectionIndex++)
//        {
//            $paginator = $this->crawlers[$collectionIndex][1]->filter('div.container--pagination div.paginate');
//            $this->pages[$collectionIndex] = $paginator->count() ? $this->crawlers[$collectionIndex][1]
//                ->filter('div.container--pagination div.paginate')
//                ->attr('data-paginate-pages') : 1;
//        }
//    }
}
