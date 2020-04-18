<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\Goods;
use App\Model\GoodCategory;
use App\Model\GoodsName;
use App\Http\Resources\Goods as GoodsResource;
use App\Http\Resources\GoodsProfile as GoodsProfileResource;
use App\Http\Resources\User as UserResource;

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
                'price' => 'required|integer|min:1',
                'unit_price' => 'required|string|max:50',
                'name_id' => 'required',
                'category_id' => 'required',
                'user_id' => 'required',
                'available_amount' => 'required|min:0',
            ]);

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
        $goods = new GoodsResource(Goods::findOrFail($id));
        $farmer = new UserResource($goods->farmer);
        $farmer_rel = GoodsProfileResource::collection($farmer->goods)->where('id','!=',$goods->id);
        $goods_rel = GoodsProfileResource::collection(Goods::where('name_id',$goods->name_id)->get())->where('id','!=',$goods->id);
        $district = $farmer->locations->first()->district;

        return response()->json([
            "message" => "goods",
            "goods" => $goods,
            "farmer" => $farmer,
            "farmer_rel" => $farmer_rel,
            "goods_rel" => $goods_rel,
        ], 201);
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
                'price' => 'required|integer|min:1',
                // 'unit_price' => 'required|string|max:50',
                'name_id' => 'required',
                'category_id' => 'required',
                'user_id' => 'required',
                'available_amount' => 'required|min:0',
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
        $name = GoodsName::where('state','active')->get(['id','name_sin']);

        return response()->json([
            "category" => $category,
            "name" => $name,
        ]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function search(Request $request)
    {
        $searchquery = $request->searchquery;

        $result =  Goods::where(function ($query) use ($searchquery) {
            $query->where('price', 'like', '%' . $searchquery . '%')
                ->orWhereHas('goodsName',function($query4) use ($searchquery) {
                    $query4->where('name', 'LIKE', '%' . $searchquery . '%')
                    ->orWhere('name_sin', 'LIKE', '%' . $searchquery . '%')
                    ->orWhere('name_eng', 'LIKE', '%' . $searchquery . '%');
                })
                ->orWhereHas('farmer',function($query3) use ($searchquery) {
                    $query3->where('name', 'LIKE', '%' . $searchquery . '%')
                    ->orWhereHas('locations',function($query2) use ($searchquery){
                        $query2->where('district', 'LIKE', '%' . $searchquery . '%')
                                ->orWhere('address', 'LIKE', '%' . $searchquery . '%');
                    });
                });
        })
        ->paginate();


        return GoodsProfileResource::collection($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function advancedSearch(Request $request)
    {

        $result =  Goods::where(function ($query) use ($request) {
            $query->whereHas('goodsName',function($query4) use ($request) {
                    $query4->where('name', 'LIKE', '%' . $request->name . '%')
                    ->orWhere('name_sin', 'LIKE', '%' . $request->name . '%')
                    ->orWhere('name_eng', 'LIKE', '%' . $request->name . '%');
                })
                ->whereHas('farmer',function($query3) use ($request) {
                    $query3->whereHas('locations',function($query2) use ($request){
                        $query2->where('district', 'LIKE', '%' . $request->district . '%')
                                ->where('gs_division', 'LIKE', '%' . $request->gs_division . '%');
                    });
                });
        })
        ->paginate();


        return GoodsProfileResource::collection($result);
    }
}
