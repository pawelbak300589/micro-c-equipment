<?php
/**
 *  GearScraper file
 */

namespace App\Services\Scrapers;

use App\Gear;
use App\Price;
use App\Repositories\GearRepository;
use App\Repositories\PriceRepository;
use App\Services\Scrapers\Gears\RockRun;

/**
 * Class GearScraper
 * @package App\Services\Scrapers
 */
class GearScraper extends GearScraperAbstract
{
    public function __construct()
    {
        parent::__construct();
        $this->repository = [
            'gear' => new GearRepository(new Gear()),
            'price' => new PriceRepository(new Price()),
        ];
        $this->websites = [
            RockRun::class
        ];
    }
}
