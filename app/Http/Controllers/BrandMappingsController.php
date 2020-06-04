<?php

namespace App\Http\Controllers;

use App\Blacklist;
use App\Brand;
use App\BrandNameMapping;
use App\Repositories\BrandNameMappingRepository;
use App\Repositories\BrandRepository;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BrandMappingsController extends Controller
{
    use ApiResponse;

    /**
     * @var BrandRepository
     */
    protected $repository;
    /**
     * @var BrandNameMappingRepository
     */
    protected $mappingRepository;

    public function __construct()
    {
        $this->repository = new BrandRepository(new Brand());
        $this->mappingRepository = new BrandNameMappingRepository(new BrandNameMapping());
    }

    public function index()
    {
        $mappings = BrandNameMapping::all();
        if ($mappings)
        {
            return $this->successResponse($mappings);
        }
        return $this->successResponse('There are no mappings in database');
    }

    public function show($id)
    {
        return $this->successResponse(BrandNameMapping::where('brand_id', '=', $id)->get());
    }
}
