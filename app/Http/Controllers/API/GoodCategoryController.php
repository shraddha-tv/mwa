<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\GoodCategory;
use App\Http\Resources\Category as CategoryResource;

class GoodCategoryController extends Controller
{
       /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CategoryResource::collection(GoodCategory::paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:50',
            ]);
            
            $GoodCategory = GoodCategory::create($request->all());

            return response()->json(["message" => "Add GoodCategory Successfully", "responce" => $GoodCategory], 201);
        } catch (Exception $e) {
            return response()->json(["message" => "Somthing want to wrong on the server."], $e->getCode());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $GoodCategory = GoodCategory::findOrFail($id);

            $request->validate([
                'name' => 'required|string|max:50',
            ]);

            $GoodCategory->update($request->all());
            return response()->json(["message" => "GoodCategory Update Successfully", "responce" => $GoodCategory], 201);
        } catch (Exception $e) {
            return response()->json(["message" => "Somthing want to wrong on the server."], $e->getCode());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $GoodCategory = GoodCategory::findOrFail($id);
        $GoodCategory->delete();
        return response()->json(null, 204);
    }
}
