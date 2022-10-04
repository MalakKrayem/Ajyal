<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=UserResource::collection(User::withoutTrashed()->get());
        if($users){
            return $this->apiResponse($users,"Ok",200);
        }
        return $this->apiResponse(null,"Not Found!",404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator($request->all(), UserRequest::rules());
        $data = $request->except("image");
        if ($request->hasFile("image")) {
            $file = $request->file("image"); //return uploadedfile object
            $path = $file->store("uploads", "public");
            $data["image_path"] = $path;
        }

        if ($validator->fails()) {
            return $this->apiResponse(null,$validator->errors(),400);
        }

        $user = new User();
        $user->first_name = $request->input("first_name");
        $user->last_name = $request->input("last_name");
        $user->email = $request->input("email");
        $user->gender = $request->input('gender');
        $user->overview = $request->input('overview');
        $user->role = $request->input('role');
        $user->phone = $request->input('phone');
        $user->password = Hash::make($request->input("password"));
        if(isset($data["image_path"])){
            $user->image = $data["image_path"];
        }
        $user->save();
        if($user){
            return $this->apiResponse(new UserResource($user),"The user saved!",201);
        }
        return $this->apiResponse(null,"The user not saved!",404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        if($user){
            return $this->apiResponse(new UserResource($user),"Ok",200);
        }
        return $this->apiResponse(null,"Not Found!",404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if(!$user){
            return $this->apiResponse(null,"Not Found!",404);
        }
        $validator = Validator($request->all(), UserRequest::rules());
        $data = $request->except("image");
        if ($request->hasFile("image")) {
            $file = $request->file("image"); //return uploadedfile object
            $path = $file->store("uploads", "public");
            $data["image_path"] = $path;
        }

        if ($validator->fails()) {
            return $this->apiResponse(null,$validator->errors(),400);
        }

        $user->first_name = $request->input("first_name");
        $user->last_name = $request->input("last_name");
        $user->email = $request->input("email");
        $user->gender = $request->input('gender');
        $user->overview = $request->input('overview');
        $user->role = $request->input('role');
        $user->phone = $request->input('phone');
        $user->password = Hash::make($request->input("password"));
        if(isset($data["image_path"])){
            $user->image = $data["image_path"];
        }
        $user->save();
        if($user){
            return $this->apiResponse(new UserResource($user),"The user updated!",201);
        }
        return $this->apiResponse(null,"The user didn't update!",404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {

        if($user){
            if ($user->image) {
                Storage::disk("public")->delete($user->image);
            }
            $user->delete();
            return $this->apiResponse($user,"The user deleted sucessfuly!",200);
        }
        return $this->apiResponse(null,"Not Found!",404);

    }
}
