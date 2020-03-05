<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function showAllCategories()
    {
        return response()->json(Category::all());
    }

    public function showOneCategory($id)
    {
        return response()->json(Category::find($id));
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'brand_id' => 'required',
            'category_id' => 'required',
            'name' => 'required|max:255',
        ]);

        $author = Category::create($request->all());

        return response()->json($author, 201);
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'brand_id' => 'required',
            'category_id' => 'required',
            'name' => 'required|max:255',
        ]);

        $author = Category::findOrFail($id);
        $author->update($request->all());

        return response()->json($author, 200);
    }

    public function delete($id)
    {
        Category::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
}
