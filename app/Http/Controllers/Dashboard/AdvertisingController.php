<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdvertisingRequest;
use App\Http\Resources\AdvertisingResource;
use App\Models\Advertising;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class AdvertisingController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $advertisings=AdvertisingResource::collection(Advertising::all());
        if($advertisings->isEmpty()){
            return $this->apiResponse(null,'No Advertisings!',Response::HTTP_NOT_FOUND);
        }
        return $this->apiResponse($advertisings,'Done',Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdvertisingRequest $request)
    {
        $data = $request->except("image");
        if ($request->hasFile("image")) {
            $file = $request->file("image"); //return uploadedfile object
            $path = $file->store("uploads", "public");
            $data["image_path"] = $path;
        }
        if ($request->hasFile("attachment")) {
            $file = $request->file("attachment"); //return uploadedfile object
            $path = $file->store("uploads", "public");
            $data["attachment_path"] = $path;
        }

        $advertising= new Advertising();
        $advertising->title = $request->input("title");
        $advertising->details = $request->input("details");
        $advertising->notes = $request->input("notes");
        $advertising->deadline = $request->input("deadline");
        $advertising->status = $request->input("status");
        if(isset($data["image_path"])){
            $advertising->image = $data["image_path"];
        }
        if(isset($data["attachment_path"])){
            $advertising->attachment = $data["attachment_path"];
        }
        $advertising->save();
        if($advertising){
            return $this->apiResponse(new AdvertisingResource($advertising),'Advertising saved Successfully!',Response::HTTP_CREATED);
        }
        return $this->apiResponse(null,'Advertising not saved!',Response::HTTP_BAD_REQUEST);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Advertising  $advertising
     * @return \Illuminate\Http\Response
     */
    public function show(Advertising $advertising)
    {
        return $this->apiResponse(new AdvertisingResource($advertising),'Done',Response::HTTP_OK);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Advertising  $advertising
     * @return \Illuminate\Http\Response
     */
    public function update(AdvertisingRequest $request, Advertising $advertising)
    {
        $data = $request->except("image");
        if ($request->hasFile("image")) {
            $file = $request->file("image"); //return uploadedfile object
            $path = $file->store("uploads", "public");
            $data["image_path"] = $path;
        }
        $advertising->title = $request->input("title");
        $advertising->details = $request->input("details");
        $advertising->notes = $request->input("notes");
        $advertising->deadline = $request->input("deadline");
        $advertising->status = $request->input("status");
        if(isset($data["image_path"])){
            $advertising->image = $data["image_path"];
        }
        $advertising->save();
        if($advertising){
            return $this->apiResponse(new AdvertisingResource($advertising),'Advertising updated Successfully!',Response::HTTP_CREATED);
        }
        return $this->apiResponse(null,'Advertising not updated!',Response::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Advertising  $advertising
     * @return \Illuminate\Http\Response
     */
    public function destroy(Advertising $advertising)
    {
        $advertising->delete();
        return $this->apiResponse(new AdvertisingResource($advertising),"The advertising deleted sucessfuly!",200);
    }
}
