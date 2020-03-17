<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Repositories\BrandRepository;
use App\Services\Scrapers\Brands\AlpinTrek;
use App\Services\Scrapers\Categories\AlpinTrek as AlpinTrekCategories;
use App\Services\Scrapers\Gears\AlpinTrek as AlpinTrekGears;
use App\Services\Scrapers\Brands\ClimbersShop;
use App\Services\Scrapers\Brands\RockRun;
use App\Services\Scrapers\Categories\RockRun as RockRunCategories;
use App\Services\Scrapers\Brands\WeighMyRack;
use App\Services\Scrapers\BrandScraper;
use App\Services\Scrapers\Categories\TrekkInn;
use App\Services\Scrapers\Gears\TrekkInn as TrekkInnGears;
use App\Services\Scrapers\Gears\ClimbersShop as ClimbersShopGears;
use App\Services\Scrapers\Gears\RockRun as RockRunGears;
use App\Services\Scrapers\GearScraper;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BrandController extends Controller
{
    use ApiResponse;

    public function showAllBrands()
    {
        return $this->successResponse(Brand::all());
    }

    public function showOneBrand($id)
    {
        return $this->successResponse(Brand::find($id));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'website' => 'required|max:255'
        ]);

        $brand = Brand::create($request->all());

        return $this->successResponse($brand, Response::HTTP_CREATED);
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'website' => 'required|max:255'
        ]);

        $brand = Brand::findOrFail($id);
        $brand->update($request->all());

        return $this->successResponse($brand);
    }

    public function delete($id)
    {
        $brand = Brand::findOrFail($id);
        $brand->delete();
        return $this->successResponse($brand);
    }

    public function test()
    {
        ini_set('max_execution_time', 300);

//        $test = new WeighMyRack();
//        $test = new ClimbersShop();
//        $test = new RockRun();
//        $test = new RockRunCategories();
//        $test = new TrekkInn();
//        $test = new AlpinTrek();
//        $test = new AlpinTrekCategories();
//        $test = new RockRunGears();
//        $test = new AlpinTrekGears();
//        $test = new TrekkInnGears();
        $test = new ClimbersShopGears();
        dd($test->getData());
//        dd($test->getData()[0]);

//        $test = new BrandScraper();
//        $test = new GearScraper();
//        dd($test->scrapeAll());
        dd('test');

//        $repository = new BrandRepository(new Brand());
//        dd($repository->create(['name' => 'Test', 'website' => 'test website']));
    }
}
