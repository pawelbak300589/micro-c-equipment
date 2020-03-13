<?php

namespace App\Services\Scrapers;

use App\Website;
use Goutte\Client;
use ReflectionClass;
use ReflectionException;

abstract class PaginatedWebsiteScraperAbstract implements WebsiteScraperInterface
{
    protected $websiteId;
    protected $goutteClient;
    protected $crawlers;
    protected $collections;
    protected $pages;

    public function __construct()
    {
        $this->goutteClient = new Client();
        $this->setPreCrawlers();
        $this->updatePagesNumber();
        $this->setCrawlers();
        $this->prepareWebsiteId();
    }

    public function updatePagesNumber()
    {
        for ($collectionIndex = 0; $collectionIndex < $this->getCollectionsNumber(); $collectionIndex++)
        {
            $this->pages[$collectionIndex] = 1;
        }
    }

    public function setCrawlers()
    {
        foreach ($this->collections as $collectionIndex => $collectionUrl)
        {
            for ($pageNum = 1; $pageNum <= $this->pages[$collectionIndex]; $pageNum++)
            {
                $this->crawlers[$collectionIndex][$pageNum] = $this->goutteClient->request('GET', $collectionUrl);
            }
        }
    }

    public function getCollectionsNumber()
    {
        return count($this->collections);
    }

    /**
     * @param bool $isSale
     * @param array $prices
     * @return string
     */
    protected function setPriceType(array $prices, bool $isSale = false)
    {
        $priceType = 'normal';
        if ($isSale)
        {
            $priceType = 'sale';
            if ($prices[0] === 'Sold Out')
            {
                $priceType = 'sold';
            }
            elseif ($prices[0] === 'from' && count($prices) === 2)
            {
                $priceType = 'normal_from';
            }
            elseif ($prices[0] === 'from' && count($prices) === 3)
            {
                $priceType = 'sale_from';
            }
        }
        return $priceType;
    }

    private function setPreCrawlers()
    {
        foreach ($this->collections as $collectionIndex => $collectionUrl)
        {
            $this->crawlers[$collectionIndex][1] = $this->goutteClient->request('GET', $collectionUrl);
        }
    }

    /**
     * Prepare website ID for website scraping data
     * (Website scraping name must be the same as website name in DB)
     *
     * @return void
     */
    private function prepareWebsiteId(): void
    {
        try
        {
            $this->websiteId = Website::where('name', (new ReflectionClass($this))->getShortName())->first()->id;
        } catch (ReflectionException $e)
        {
            dd($e->getMessage());
        }
    }
}
