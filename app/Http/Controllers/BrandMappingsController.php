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

    public function __construct()
    {
        $this->repository = new BrandNameMappingRepository(new BrandNameMapping());
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

    public function show($brandId)
    {
        return $this->successResponse(BrandNameMapping::where('brand_id', '=', $brandId)->get());
    }

    public function store(Request $request, $brandId)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);

        $brandMapping = $this->repository->create([
            'brand_id' => $brandId,
            'name' => $request->name,
        ]);

        if ($brandMapping)
        {
            return $this->successResponse($brandMapping, Response::HTTP_CREATED);
        }
        return $this->errorResponse('Something went wrong - brand mapping not created!', Response::HTTP_CONFLICT);
    }

    public function update(Request $request, $brandId, $mappingId)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);

        $brandMapping = BrandNameMapping::findOrFail($mappingId);

        $brandMapping->update([
            'brand_id' => $brandId,
            'name' => $request->name,
        ]);

        if ($brandMapping)
        {
            return $this->successResponse($brandMapping->fresh());
        }
        return $this->errorResponse('Something went wrong - brand mapping not created!', Response::HTTP_CONFLICT);
    }

    public function delete($brandId, $mappingId)
    {
        $mapping = BrandNameMapping::findOrFail($mappingId);
        $mapping->delete();
        return $this->successResponse($mapping->id);
    }
}
