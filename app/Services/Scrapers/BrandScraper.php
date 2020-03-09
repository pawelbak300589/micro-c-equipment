<?php
/**
 *  BrandScraper file
 */

namespace App\Services\Scrapers;

use App\Brand;
use App\Repositories\BrandRepository;
use App\Services\Scrapers\Brands\RockRun;
use App\Services\Scrapers\Brands\WeighMyRack;
use App\Services\Scrapers\Brands\ClimbersShop;

/**
 * Class BrandScraper
 * @package App\Services\Scrapers
 */
class BrandScraper extends ScraperAbstract
{
    public function __construct()
    {
        parent::__construct();
        $this->repository = new BrandRepository(new Brand());
        $this->websites = [
            WeighMyRack::class,
            RockRun::class,
//        ClimbersShop::class,
        ];
    }
}
