<?php

namespace App\Http\Controllers;

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

    public function __construct(Request $request)
    {
        $this->repository = new BrandNameMappingRepository(Brand::findOrFail($request->brandId));
    }

    public function index($brandId)
    {
        return $this->successResponse(BrandNameMapping::where('brand_id', '=', $brandId)->get());
    }

    public function show($brandId, $mappingId)
    {
        return $this->successResponse(BrandNameMapping::findOrFail($mappingId));
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
        return $this->errorResponse('Something went wrong - brand mapping not updated!', Response::HTTP_CONFLICT);
    }

    public function delete($brandId, $mappingId)
    {
        $mapping = BrandNameMapping::findOrFail($mappingId);
        $mapping->delete();
        return $this->successResponse($mapping->id);
    }
}
