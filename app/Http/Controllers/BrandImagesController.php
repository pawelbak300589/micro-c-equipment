<?php

namespace App\Http\Controllers;

use App\Brand;
use App\BrandImages;
use App\Repositories\BrandImagesRepository;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BrandImagesController extends Controller
{
    use ApiResponse;

    /**
     * @var BrandImagesRepository
     */
    protected $repository;

    public function __construct(Request $request)
    {
        $this->repository = new BrandImagesRepository(Brand::findOrFail($request->brandId));
    }

    public function index($brandId)
    {
        return $this->successResponse(BrandImages::where('brand_id', '=', $brandId)->get());
    }

    public function show($imageId)
    {
        return $this->successResponse(BrandImages::findOrFail($imageId));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'src' => 'required|max:255',
        ]);

        $brandImage = $this->repository->create($request->src);

        if ($brandImage)
        {
            return $this->successResponse($brandImage, Response::HTTP_CREATED);
        }
        return $this->errorResponse('Something went wrong - brand image not added!', Response::HTTP_CONFLICT);
    }

    public function update(Request $request, $brandId, $imageId)
    {
        $this->validate($request, [
            'src' => 'required|max:255',
            'alt' => 'required|max:255',
            'main' => 'required',
        ]);

        $brandImage = BrandImages::findOrFail($imageId);

        $brandImage->update([
            'brand_id' => $brandId,
            'src' => $request->src,
            'alt' => $request->alt,
            'main' => $request->main,
        ]);

        if ($brandImage)
        {
            return $this->successResponse($brandImage->fresh());
        }
        return $this->errorResponse('Something went wrong - brand image not updated!', Response::HTTP_CONFLICT);
    }

    public function delete($imageId)
    {
        $image = BrandImages::findOrFail($imageId);
        $image->delete();
        return $this->successResponse($image->id);
    }
}
