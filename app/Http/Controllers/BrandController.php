<?php

namespace App\Http\Controllers;

use App\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{

    public function showAllBrands()
    {
        return response()->json(Brand::all());
    }

    public function showOneBrand($id)
    {
        return response()->json(Brand::find($id));
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'website' => 'required|max:255'
        ]);

        $brand = Brand::create($request->all());

        return response()->json($brand, 201);
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'website' => 'required|max:255'
        ]);

        $brand = Brand::findOrFail($id);
        $brand->update($request->all());

        return response()->json($brand, 200);
    }

    public function delete($id)
    {
        Brand::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
}
