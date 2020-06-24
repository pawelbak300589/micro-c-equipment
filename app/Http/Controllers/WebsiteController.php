<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponse;
use App\Website;
use Illuminate\Http\Response;

class WebsiteController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $websites = Website::all();
        if ($websites)
        {
            return $this->successResponse($websites);
        }
        return $this->errorResponse('There are no websites in database', Response::HTTP_BAD_REQUEST);
    }
}
