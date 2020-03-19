<?php
/**
 *  GearScraper file
 */

namespace App\Services\Scrapers;

use App\Gear;
use App\Price;
use App\Repositories\GearRepository;
use App\Repositories\PriceRepository;
use App\Services\Scrapers\Gears\AlpinTrek;
use App\Services\Scrapers\Gears\ClimbersShop;
use App\Services\Scrapers\Gears\CotswoldOutdoor;
use App\Services\Scrapers\Gears\Decathlon;
use App\Services\Scrapers\Gears\EllisBrigham;
use App\Services\Scrapers\Gears\RockRun;
use App\Services\Scrapers\Gears\TrekkInn;

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
            AlpinTrek::class,
            //ClimbersShop::class, // TODO: not working because JavaScript loading - use Panther or Laravel Dusk
            CotswoldOutdoor::class,
            Decathlon::class,
            //EllisBrigham::class, // TODO: not working because JavaScript loading - use Panther or Laravel Dusk
            RockRun::class,
            TrekkInn::class,
        ];
    }
}
