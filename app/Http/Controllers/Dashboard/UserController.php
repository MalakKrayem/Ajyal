<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

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
        $users=UserResource::collection(User::get());
        if($users->isEmpty()){
            return $this->apiResponse(null,"Not Found!",404);
        }
        return $this->apiResponse($users,"Ok",200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        //return $request;

        $data = $request->except("image");

        if ($request->hasFile("image")) {
            $file = $request->file("image"); //return uploadedfile object
            $path = $file->store("uploads", "public");
            $data["image_path"] = $path;
        }

        $user = new User();
        $user->first_name = $request->input("first_name");
        $user->last_name = $request->input("last_name");
        $user->email = $request->input("email");
        $user->gender = $request->input('gender');
        $user->overview = $request->input('overview');
        $user->position_description = $request->input('position_description');
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
        return $this->apiResponse(new UserResource($user),"Done",200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\UserRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => [
                'required',
                Rule::unique('users')->ignore($user->id),
                'email'
            ],
            'phone' => [
                'required',
                Rule::unique('users')->ignore($user->id),
                'numeric'
            ],
            'gender'=>'required|string|in:female,male',
            'image'=>'mimes:jpg,png',
            'overview' => 'string|max:255',
            'position_description'=>'required|string|max:255'
        ]);
        $data = $request->except("image");

        if ($request->hasFile("image")) {
            $file = $request->file("image"); //return uploadedfile object
            $path = $file->store("uploads", "public");
            $data["image_path"] = $path;
        }

        $user->first_name = $request->input("first_name");
        $user->last_name = $request->input("last_name");
        $user->email = $request->input("email");
        $user->gender = $request->input('gender');
        $user->overview = $request->input('overview');
        $user->position_description = $request->input('position_description');
        $user->phone = $request->input('phone');
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return $this->apiResponse($user,"The user deleted!",200);
    }
}
