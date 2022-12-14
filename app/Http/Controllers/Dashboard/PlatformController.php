<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlatformRequest;
use App\Http\Resources\PlatformResource;
use App\Models\Platform;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class PlatformController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $platforms = PlatformResource::collection(Platform::all());
        if ($platforms->isEmpty()) {
            return $this->apiResponse(null, 'No platforms found', 404);
        }
        return $this->apiResponse($platforms,'Done',Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PlatformRequest $request)
    {
        $data = $request->except("image");
        if ($request->hasFile("image")) {
            $file = $request->file("image"); //return uploadedfile object
            $path = $file->store("uploads", "public");
            $data["image_path"] = $path;
        }
        $platform= new Platform();
        $platform->name = $request->input("name");
        $platform->jobs_count = $request->input("jobs_count");
        if(isset($data["image_path"])){
            $platform->image = $data["image_path"];
        }
        $platform->save();
        if($platform){
            return $this->apiResponse(new PlatformResource($platform),'Platform added successfully!',Response::HTTP_CREATED);
        }
        return $this->apiResponse(null,'Error',500);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Platform  $platform
     * @return \Illuminate\Http\Response
     */
    public function show(Platform $platform)
    {
        return $this->apiResponse(new PlatformResource($platform),'Done',Response::HTTP_OK);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Platform  $platform
     * @return \Illuminate\Http\Response
     */
    public function update(PlatformRequest $request, Platform $platform)
    {
        $data = $request->except("image");
        if ($request->hasFile("image")) {
            $file = $request->file("image"); //return uploadedfile object
            $path = $file->store("uploads", "public");
            $data["image_path"] = $path;
        }
        $platform->name = $request->input("name");
        $platform->jobs_count = $request->input("jobs_count");
        if(isset($data["image_path"])){
            $platform->image = $data["image_path"];
        }
        $platform->save();
        
        if($platform){
            return $this->apiResponse(new PlatformResource($platform),'Platform updated successfully!',Response::HTTP_CREATED);
        }
        return $this->apiResponse(null,'Error',500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Platform  $platform
     * @return \Illuminate\Http\Response
     */
    public function destroy(Platform $platform)
    {
        $platform->delete();
        return $this->apiResponse(new PlatformResource($platform),"The platform deleted sucessfuly!",Response::HTTP_OK);
    }
}