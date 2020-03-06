<?php

namespace App\Http\Controllers;

use App\Gear;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GearController extends Controller
{
    use ApiResponse;

    public function showAllGears()
    {
        return $this->successResponse(Gear::all());
    }

    public function showOneGear($id)
    {
        return $this->successResponse(Gear::find($id));
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'brand_id' => 'required',
            'category_id' => 'required',
            'name' => 'required|max:255',
        ]);

        $gear = Gear::create($request->all());

        return $this->successResponse($gear, Response::HTTP_CREATED);
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'brand_id' => 'required',
            'category_id' => 'required',
            'name' => 'required|max:255',
        ]);

        $gear = Gear::findOrFail($id);
        $gear->update($request->all());

        return $this->successResponse($gear);
    }

    public function delete($id)
    {
        $gear = Gear::findOrFail($id);
        $gear->delete();
        return $this->successResponse($gear);
    }
}
