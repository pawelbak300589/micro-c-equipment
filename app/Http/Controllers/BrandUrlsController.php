<?php

namespace App\Http\Controllers;

use App\Brand;
use App\BrandUrls;
use App\Repositories\BrandUrlsRepository;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BrandUrlsController extends Controller
{
    use ApiResponse;

    /**
     * @var BrandUrlsRepository
     */
    protected $repository;

    public function __construct(Request $request)
    {
        $this->repository = new BrandUrlsRepository(Brand::findOrFail($request->brandId));
    }

    public function index($brandId)
    {
        return $this->successResponse(BrandUrls::where('brand_id', '=', $brandId)->get());
    }

    public function show($urlId)
    {
        return $this->successResponse(BrandUrls::findOrFail($urlId));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'website_id' => 'required',
            'url' => 'required|max:255'
        ]);

        $brandUrl = $this->repository->create($request->all());

        if ($brandUrl)
        {
            return $this->successResponse($brandUrl, Response::HTTP_CREATED);
        }
        return $this->errorResponse('Something went wrong - brand url not added!', Response::HTTP_CONFLICT);
    }

    public function update(Request $request, $brandId, $urlId)
    {
        $this->validate($request, [
            'website_id' => 'required',
            'url' => 'required|max:255'
        ]);

        $brandUrl = BrandUrls::findOrFail($urlId);

        $brandUrl->update([
            'website_id' => $request->website_id,
            'brand_id' => $brandId,
            'url' => $request->url
        ]);

        if ($brandUrl)
        {
            return $this->successResponse($brandUrl->fresh());
        }
        return $this->errorResponse('Something went wrong - brand url not updated!', Response::HTTP_CONFLICT);
    }

    public function delete($urlId)
    {
        $url = BrandUrls::findOrFail($urlId);

        if ($url->main === 1)
        {
            $firstUrl = BrandUrls::where('brand_id', '=', $url->brand_id)->first();
            if ($firstUrl)
            {
                $firstUrl->main = 1;
                $firstUrl->update();
            }
        }

        $url->delete();
        return $this->successResponse(BrandUrls::where('brand_id', '=', $url->brand_id)->get());
    }

    public function main($urlId)
    {
        $url = $this->repository->setAsMainImage($urlId);
        return $this->successResponse($url->id);
    }
}
