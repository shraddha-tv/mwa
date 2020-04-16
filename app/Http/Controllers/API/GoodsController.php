<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\Goods;
use App\Model\GoodCategory;
use App\Model\GoodsName;
use App\Http\Resources\Goods as GoodsResource;

class GoodsController extends Controller
{

    public function controler(Request $request, $var)
    {
        if(is_numeric($var)){
            return $this->show($var);
        }else{
            return $this->$var($request);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return GoodsResource::collection(Goods::paginate());
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

            $request['password'] =  bcrypt('password');
            $goods = Goods::create($request->all());

            return response()->json(["message" => "Add goods Successfully", "responce" => $goods], 201);
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
            $goods = Goods::findOrFail($id);

            $request->validate([
                'name' => 'required|string|max:50',
            ]);

            $goods->update($request->all());
            return response()->json(["message" => "goods Update Successfully", "responce" => $goods], 201);
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
        $goods = Goods::findOrFail($id);
        $goods->delete();
        return response()->json(null, 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function asserts()
    {
        $category = GoodCategory::where('state','active')->get(['id','name']);
        $name = GoodsName::where('state','active')->get(['id','name']);

        return response()->json([
            "category" => $category,
            "name" => $name,
        ]);
    }
}
