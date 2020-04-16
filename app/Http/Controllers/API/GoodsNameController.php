<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\GoodsName;
use App\Http\Resources\GoodsName as GoodsNameResource;

class GoodsNameController extends Controller
{ 
    
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
       return GoodsNameResource::collection(GoodsName::paginate());
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
           $GoodsName = GoodsName::create($request->all());

           return response()->json(["message" => "Add GoodsName Successfully", "responce" => $GoodsName], 201);
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
           $GoodsName = GoodsName::findOrFail($id);

           $request->validate([
               'name' => 'required|string|max:50',
           ]);

           $GoodsName->update($request->all());
           return response()->json(["message" => "GoodsName Update Successfully", "responce" => $GoodsName], 201);
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
       $GoodsName = GoodsName::findOrFail($id);
       $GoodsName->delete();
       return response()->json(null, 204);
   }
}
