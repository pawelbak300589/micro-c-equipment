<?php

namespace App\Http\Controllers;

use App\Category;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    use ApiResponse;

    public function showAllCategories()
    {
        return $this->successResponse(Category::all());
    }

    public function showOneCategory($id)
    {
        return $this->successResponse(Category::find($id));
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'brand_id' => 'required',
            'category_id' => 'required',
            'name' => 'required|max:255',
        ]);

        $category = Category::create($request->all());

        return $this->successResponse($category, Response::HTTP_CREATED);
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'brand_id' => 'required',
            'category_id' => 'required',
            'name' => 'required|max:255',
        ]);

        $category = Category::findOrFail($id);
        $category->update($request->all());

        return $this->successResponse($category);
    }

    public function delete($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return $this->successResponse($category);
    }
}
