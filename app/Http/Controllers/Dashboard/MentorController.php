<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\MentorRequest;
use App\Http\Resources\MentorResource;
use App\Models\Mentor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class MentorController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mentors=MentorResource::collection(Mentor::all());
        if($mentors->isEmpty()){
            return $this->apiResponse(null,"There is no mentors!",404);
        }
        return $this->apiResponse($mentors,"Done",200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MentorRequest $request)
    {
        $data = $request->except("image");
        if ($request->hasFile("image")) {
            $file = $request->file("image"); //return uploadedfile object
            $path = $file->store("uploads", "public");
            $data["image_path"] = $path;
        }

        $mentor = new Mentor();
        $mentor->first_name = $request->input("first_name");
        $mentor->last_name = $request->input("last_name");
        $mentor->email = $request->input("email");
        $mentor->gender = $request->input('gender');
        $mentor->overview = $request->input('overview');
        $mentor->phone = $request->input('phone');
        $mentor->password = Hash::make($request->input("password"));
        if(isset($data["image_path"])){
            $mentor->image = $data["image_path"];
        }
        $mentor->save();
        if($mentor){
            return $this->apiResponse(new MentorResource($mentor),"Mentor saved successfully!",Response::HTTP_CREATED);
        }
        return $this->apiResponse(null, "Something wrong!", Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mentor  $mentor
     * @return \Illuminate\Http\Response
     */
    public function show(Mentor $mentor)
    {

        return $this->apiResponse(new MentorResource($mentor),"Ok",Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mentor  $mentor
     * @return \Illuminate\Http\Response
     */
    public function update(MentorRequest $request, Mentor $mentor)
    {
        $data = $request->except("image");
        if ($request->hasFile("image")) {
            $file = $request->file("image"); //return uploadedfile object
            $path = $file->store("uploads", "public");
            $data["image_path"] = $path;
        }

        $mentor->first_name = $request->input("first_name");
        $mentor->last_name = $request->input("last_name");
        $mentor->email = $request->input("email");
        $mentor->gender = $request->input('gender');
        $mentor->overview = $request->input('overview');
        $mentor->phone = $request->input('phone');
        $mentor->password = Hash::make($request->input("password"));
        if(isset($data["image_path"])){
            $mentor->image = $data["image_path"];
        }
        $mentor->save();
        if($mentor){
            return $this->apiResponse(new MentorResource($mentor), "Mentor updated successfully!", Response::HTTP_OK);
        }
        return $this->apiResponse(null, "Something wrong!", Response::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mentor  $mentor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mentor $mentor)
    {
        $mentor->delete();
        return $this->apiResponse(new MentorResource($mentor),"The mentor deleted sucessfuly!",200);
    }
}
