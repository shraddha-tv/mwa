<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\User;
use App\Model\State;
use App\Model\Location;
use App\Model\Contact;
use App\Http\Resources\User as UserResource;

class UserController extends Controller
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
        return UserResource::collection(User::where('type','!=','farmers')->paginate());
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
            $request['state_id'] =  1;
            $request['create_by'] =  $request->user()->id;

            $location = $request->location;
            unset($request['location']);

            $user = User::create($request->all());

            // create location
            $user->locations()->create($location);

            // create contacts
            $contacts = $request->contact;
            foreach ($contacts as $item) {
                $user->contacts()->create(["number"=>$item]);
            }


            return response()->json(["message" => "Add User Successfully", "responce" => $user], 201);
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
        $item = User::findOrFail($id);
        return new UserResource($item);
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
            $user = User::findOrFail($id);

            $request->validate([
                'name' => 'required|string|max:50',
            ]);

            if($request->verify == "verified"){
                $request['verified_by'] =  $request->user()->id;
            }

            $user->update($request->all());

            // update location
            $user->locations()->update($request->location);

            // update contacts
            $contacts = $request->contact;
            foreach ($contacts as $item) {
                $number = Contact::where('number',$item)->first();
                if($number != null){
                    $number->Update(["number"=>$item]);
                }else{
                    $user->contacts()->create(["number"=>$item]);
                }
            }
            
            return response()->json(["message" => "User Update Successfully", "responce" => $user], 201);
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
        $user = User::findOrFail($id);
        $user->delete();
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
        $state = State::where('state','active')->get(['id','name']);

        return response()->json([
            "state" => $state
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function farmers(Request $request)
    {
        $searchquery = $request->searchquery;

        $result =  User::where('type','farmers')
        ->where(function ($query) use ($searchquery) {
            $query->where('name', 'like', '%' . $searchquery . '%')
                ->orWhere('email', 'LIKE', '%' . $searchquery . '%')
                ->orWhere('nic', 'LIKE', '%' . $searchquery . '%');
        })
        ->paginate();


        return UserResource::collection($result);
    }
}
