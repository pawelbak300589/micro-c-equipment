<?php

namespace App\Http\Controllers;

use App\Gear;
use Illuminate\Http\Request;

class GearController extends Controller
{

    public function showAllGears()
    {
        return response()->json(Gear::all());
    }

    public function showOneGear($id)
    {
        return response()->json(Gear::find($id));
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'brand_id' => 'required',
            'category_id' => 'required',
            'name' => 'required|max:255',
        ]);

        $author = Gear::create($request->all());

        return response()->json($author, 201);
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'brand_id' => 'required',
            'category_id' => 'required',
            'name' => 'required|max:255',
        ]);

        $author = Gear::findOrFail($id);
        $author->update($request->all());

        return response()->json($author, 200);
    }

    public function delete($id)
    {
        Gear::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
}
