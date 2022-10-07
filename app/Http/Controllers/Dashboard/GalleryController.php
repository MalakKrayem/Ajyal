<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\GalleryRequest;
use App\Http\Resources\GalleryResource;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class GalleryController extends Controller
{
    use ApiResponseTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $galleries = GalleryResource::collection(Gallery::all());
        if ($galleries->isEmpty()) {
            return $this->apiResponse(null, 'No partners found', 404);
        }
        return $this->apiResponse($galleries,'Done',Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(GalleryRequest::rules());
        $data = $request->except("image");
        if ($request->hasFile("image")) {
            $file = $request->file("image"); //return uploadedfile object
            $path = $file->store("uploads", "public");
            $data["image_path"] = $path;
        }
        $gallery= new Gallery();
        $gallery->course_id = $request->input("course_id");
        $gallery->description = $request->input("description");

        if(isset($data["image_path"])){
            $gallery->image_path = $data["image_path"];
        }
        $gallery->save();
        if($gallery){
            return $this->apiResponse(new GalleryResource($gallery),'Gallery added successfully!',Response::HTTP_CREATED);
        }
        return $this->apiResponse(null,'Error',Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Gallery $gallery)
    {

        return new GalleryResource($gallery);

        return $gallery
            ->load('course:id,title');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
    public function update(Request $request,Gallery $gallery)
    {
        if(!$gallery){
            return $this->apiResponse(null,'Not found!',500);
        }
        $request->validate(GalleryRequest::rules());
        $data = $request->except("image");
        if ($request->hasFile("image")) {
            $file = $request->file("image"); //return uploadedfile object
            $path = $file->store("uploads", "public");
            $data["image_path"] = $path;
        }

        if(isset($data["image_path"])){
            $gallery->image_path = $data["image_path"];
        }
        $gallery->update($request->all());

        if($gallery){
            return $this->apiResponse(new GalleryResource($gallery),'Gallery update succeccfully!',Response::HTTP_OK);

        }
            return $this->apiResponse(null,"The Gallery not updated!",404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gallery $gallery)
    {
        if($gallery){
            if($gallery->image) {
                Storage::disk("public")->delete($gallery->image);
            }
            $gallery->delete();
            return $this->apiResponse(null,"The gallery deleted sucessfuly!",200);
        }else{
            return $this->apiResponse(null,"Not Found!",Response::HTTP_NOT_FOUND);

    }
}
}
